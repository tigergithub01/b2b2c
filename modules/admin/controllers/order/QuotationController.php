<?php

namespace app\modules\admin\controllers\order;

use Yii;
use app\models\b2b2c\Quotation;
use app\models\b2b2c\search\QuotationSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\SheetType;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\SysParameter;
use app\modules\admin\models\AdminConst;
use app\models\b2b2c\QuotationDetail;
use app\models\b2b2c\Product;

/**
 * QuotationController implements the CRUD actions for Quotation model.
 */
class QuotationController extends BaseAuthController
{
    /**
     * @inheritdoc
     */
     /*
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    */

    /**
     * Lists all Quotation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuotationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'vipList' => $this->findVipList(SysParameter::no),
        		'merchantList' => $this->findVipList(SysParameter::yes),
        		'serviceStyleList' => SysParameterType::getSysParametersById(SysParameterType::SERVICE_STYLE),
        		'relatedServiceList' => SysParameterType::getSysParametersById(SysParameterType::RELATED_SERVICE),
        		'statusList' => SysParameterType::getSysParametersById(SysParameterType::QUOTATION_STATUS),
        ]);
    }

    /**
     * Displays a single Quotation model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model =  $this->findModel($id);
    	$quotationDetailList = $this->findQuotationDetailList($id);
    	
    	return $this->render('view', [
    			'model' => $model,
    			'quotationDetailList' => $quotationDetailList,
    	]);
    }

    /**
     * Creates a new Quotation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Quotation();
        
        $model->code = SheetType::getCode(SheetType::qu);
        $model->create_date = \app\common\utils\DateUtils::formatDatetime();
        $model->update_date = \app\common\utils\DateUtils::formatDatetime();
        $model->service_date = \app\common\utils\DateUtils::formatDatetime();
        $model->status = Quotation::stat_need_reply;

        if ($model->load(Yii::$app->request->post()) /* && $model->save() */) {
        	
        	$transaction = Quotation::getDb()->beginTransaction();
        	try {
        		//重新获取订单编号
        		$model->code = SheetType::getCode(SheetType::qu, true);
        		 
        		/* 保存失败处理 */
        		if(!($model->save())){
        			$transaction->rollBack();
        			return $this->renderCreate($model);
        		}
        		 
        		$transaction->commit();
        		MsgUtils::success();
        		return $this->redirect(['view', 'id' => $model->id]);
        		 
        	}catch (\Exception $e) {
        		$transaction->rollBack();
        		$model->addError('code',$e->getMessage());
        		return $this->renderCreate($model);
        	}
        	
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
        	return $this->renderCreate($model);
        }
    }
    
    /**
     * @return Ambigous <string, string>
     */
    protected function renderCreate($model){
    	return $this->render('create', [
    			'model' => $model,
    			'vipList' => $this->findVipList(SysParameter::no),
    			'merchantList' => $this->findVipList(SysParameter::yes),
    			'serviceStyleList' => SysParameterType::getSysParametersById(SysParameterType::SERVICE_STYLE),
    			'relatedServiceList' => SysParameterType::getSysParametersById(SysParameterType::RELATED_SERVICE),
    			'statusList' => SysParameterType::getSysParametersById(SysParameterType::QUOTATION_STATUS),
    	]);
    }
    
    

    /**
     * Updates an existing Quotation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
        	return $this->renderUpdate($model);
        }
    }
    
    /**
     * @return Ambigous <string, string>
     */
    protected function renderUpdate($model){
    	return $this->render('update', [
    			'model' => $model,
    			'vipList' => $this->findVipList(SysParameter::no),
    			'merchantList' => $this->findVipList(SysParameter::yes),
    			'serviceStyleList' => SysParameterType::getSysParametersById(SysParameterType::SERVICE_STYLE),
    			'relatedServiceList' => SysParameterType::getSysParametersById(SysParameterType::RELATED_SERVICE),
    			'statusList' => SysParameterType::getSysParametersById(SysParameterType::QUOTATION_STATUS),
    	]);
    }

    /**
     * Deletes an existing Quotation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		MsgUtils::success();
        return $this->redirect(['index']);
    }
    
    
    /**
     * 添加咨询明细
     * @return \yii\web\Response|Ambigous <string, string>
     */
    public function actionCreateQuotationDetail($quotation_id){
    	$model = new QuotationDetail();
    	$model->quotation_id = $quotation_id;
    	$model->quantity = 1;
    	$model->amount = 0;
    
    	//查询订单
    	$quotation = Quotation::findOne($quotation_id);
    	if(empty($quotation)){
    		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
    
    	if ($model->load(Yii::$app->request->post())) {
    
    		$model->amount = $model->quantity * $model->price;
    
    		$transaction = QuotationDetail::getDb()->beginTransaction();
    		try {
    			/* 保存失败处理 */
    			if(!($model->save())){
    				$transaction->rollBack();
    				return $this->renderCreateQuotationDetail($model, $quotation);
    			}
    			 
    			$transaction->commit();
    			MsgUtils::success();
    			return $this->redirect(['view', 'id' => $quotation_id]);
    
    		}catch (\Exception $e) {
    			$transaction->rollBack();
    			MsgUtils::error('操作失败: ' . $e->getMessage());
    			return $this->renderCreateQuotationDetail($model, $quotation);
    		}
    	}
    
    	return $this->renderCreateQuotationDetail($model, $quotation);
    }
    
    
    public function renderCreateQuotationDetail($model, $quotation){
    	return $this->render('create-quotation-detail', [
    			'model' => $model,
    			'quotation' => $quotation,
    			'productList' => $this->findProductList(),
    	]);
    }
    
    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDeleteQuotationDetail($id)
    {
    	$transaction = QuotationDetail::getDb()->beginTransaction();
    	try {
    		$quotationDetail = QuotationDetail::findOne($id);
    		if(empty($quotationDetail)){
    			throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    		}
    		$quotationDetail->delete();
    		$quotation_id = $quotationDetail->quotation_id;
    		 
    		$transaction->commit();
    		MsgUtils::success();
    		return $this->redirect(['view', 'id' => $quotation_id]);
    		 
    	}catch (\Exception $e) {
    		$transaction->rollBack();
    		MsgUtils::error('操作失败: ' . $e->getMessage());
    	}
    	 
    	return $this->redirect(['view','id'=>$quotationDetail->quotation_id]);
    }

    /**
     * Finds the Quotation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Quotation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = Quotation::find()->alias("quot")
    	->joinWith("vip vip")
    	->joinWith("merchant merchant")
    	->joinWith("status0 status0")
    	->joinWith("serviceStyle serviceStyle")
    	->where(['quot.id' => $id])->one();
    	 
    	if($model){
    		if($model->related_services){
    			$related_service_names = [];
    			foreach ($model->related_services as $value) {
    				$related_service_names[] =  SysParameter::findOne($value)->param_val;
    			}
    			$model->related_service_names = implode("，", $related_service_names);
    		}
    		return $model;
    	} else {
    		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipList($merchant_flag){
    	return Vip::find()->where(['merchant_flag'=>$merchant_flag, 'audit_status' => SysParameter::audit_approved])->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    function findQuotationDetailList($quotation_id){
    	$models = QuotationDetail::find()->alias('quotDetail')
    	->joinWith('quotation quotation')
    	->joinWith('product product')
    	->where(['quotDetail.quotation_id' => $quotation_id])->all();
    	return $models;
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findProductList(){
    	return  Product::find()->alias('p')
    	->joinWith('vip vip')
    	->where(['vip.audit_status' => SysParameter::audit_approved])->all();
    }
    
    
}
