<?php

namespace app\modules\vip\controllers\api\member\order;

use Yii;
use app\models\b2b2c\Quotation;
use app\models\b2b2c\search\QuotationSearch;
use app\modules\vip\common\controllers\BaseAuthApiController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\SheetType;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\SysParameter;
use app\modules\vip\models\VipConst;
use app\models\b2b2c\QuotationDetail;
use app\models\b2b2c\Product;
use app\models\b2b2c\common\PaginationObj;
use app\common\utils\CommonUtils;
use app\common\utils\UrlUtils;
use yii\helpers\ArrayHelper;
use app\modules\vip\service\order\QuotationService;
use app\modules\vip\service\vip\MerchantService;

/**
 * QuotationController implements the CRUD actions for Quotation model.
 */
class QuotationController extends BaseAuthApiController
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
        $searchModel->vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$quotationService = new QuotationService();
        
        
        $models = $dataProvider->getModels();
        $pagionationObj = new PaginationObj($quotationService->getQuotationModelArray($models), $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
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
    	
    	//格式化
    	$quotationService = new QuotationService();
    	
    	return CommonUtils::json_success([
    			'model'=>$quotationService->getQuotationModelArray($model),
    			'quotationDetailList'=>$quotationService->getQuotationDetailModelArray($quotationDetailList),
    	]);
    }

    /**
     * Creates a new Quotation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$merchantService = new MerchantService();
        $model = new Quotation();
        
       
        
        $merchant_id = isset ( $_REQUEST ['merchant_id'] ) ? $_REQUEST ['merchant_id'] : null;
        if(empty($merchant_id)){
        	return CommonUtils::json_failed ( '商户编号不能为空！' );
        }
        
        $merchant = Vip::find ()->where ( [
        		'id' => $merchant_id,
        		'merchant_flag' => SysParameter::yes,
        		'audit_status' => SysParameter::audit_approved
        ] )->one ();
        if (empty ( $merchant )) {
        	return CommonUtils::json_failed ( '商户不存在！' );
        }
        
        $model->vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
        $model->code = SheetType::getCode(SheetType::qu);
        $model->create_date = \app\common\utils\DateUtils::formatDatetime();
        $model->update_date = \app\common\utils\DateUtils::formatDatetime();
        $model->service_date = \app\common\utils\DateUtils::formatDatetime();
        $model->status = Quotation::stat_need_reply;
        $model->merchant_id = $merchant->id;
        

        if ($model->load(Yii::$app->request->post()) /* && $model->save() */) {
        	
        	$transaction = Quotation::getDb()->beginTransaction();
        	try {
        		//重新获取订单编号
        		$model->code = SheetType::getCode(SheetType::qu, true);
        		 
        		/* 保存失败处理 */
        		if(!($model->save())){
        			$transaction->rollBack();
        			return CommonUtils::jsonModel_failed($model);
        		}
        		 
        		$transaction->commit();
        		return CommonUtils::json_success($model->id);
        	}catch (\Exception $e) {
        		$transaction->rollBack();
        		$model->addError('code',$e->getMessage());
        		return CommonUtils::jsonModel_failed($model);
        	}
        } 
       	
        return CommonUtils::json_success([
        		'merchant' => $merchantService->getMerchantModelArray($merchant),
        		'serviceStyleList' => SysParameterType::getSysParametersById(SysParameterType::SERVICE_STYLE),
        		'relatedServiceList' => SysParameterType::getSysParametersById(SysParameterType::RELATED_SERVICE),
        		'vip'=>\Yii::$app->session->get(VipConst::LOGIN_VIP_USER),
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
    	->joinWith("order order")
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
    	->joinWith('product.vip vip')
    	->joinWith('product.vip.vipType vipType')
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
