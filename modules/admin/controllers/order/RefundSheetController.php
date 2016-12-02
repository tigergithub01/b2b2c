<?php

namespace app\modules\admin\controllers\order;

use Yii;
use app\models\b2b2c\RefundSheet;
use app\models\b2b2c\search\RefundSheetSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\RefundSheetApply;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\Vip;
use app\models\b2b2c\ReturnSheet;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\SheetType;
use app\modules\admin\models\AdminConst;

/**
 * RefundSheetController implements the CRUD actions for RefundSheet model.
 */
class RefundSheetController extends BaseAuthController
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
     * Lists all RefundSheet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefundSheetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RefundSheet model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RefundSheet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new RefundSheet();
        $model->sheet_type_id = SheetType::rd;
        $model->code = SheetType::getCode($model->sheet_type_id);
        $model->status = RefundSheet::status_need_confirm;
        $model->sheet_date = date(AdminConst::DATE_FORMAT, time());
        $model->user_id = \Yii::$app->session->get(AdminConst::LOGIN_ADMIN_USER)->id;
        
        $refund_apply_id = isset($_REQUEST['refund_apply_id'])?$_REQUEST['refund_apply_id']:null;
        if($refund_apply_id){
        	$refundApplySheet = RefundSheetApply::findOne($refund_apply_id);
        	$soSheet = $refundApplySheet->order;
        	$model->refund_apply_id = $refundApplySheet->id;
        	$model->order_id = $soSheet->id;
        	$model->status = RefundSheet::status_completed;
        	$model->vip_id = $soSheet->vip_id;
        }
        

        if ($model->load(Yii::$app->request->post())/*  && $model->save() */) {
        	
          	$transaction = RefundSheetApply::getDb()->beginTransaction();
        	try {
        		//重新获取订单编号
        		$model->code = SheetType::getCode($model->sheet_type_id, true);
        		 
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
    
    private function renderCreate($model){
    	return $this->render('create', [
    			'model' => $model,
    			'merchantList' => $this->findVipList(SysParameter::yes),
    			'orderList' => $this->findSoSheetList(),
    			'returnList' => $this->findReturnSheetList(),
    			'refundApplyList' => $this->findRefundSheetApplyList(),
    			'userList' => $this->findSysUserList(),
    			'refundStatusList' => SysParameterType::getSysParametersById(SysParameterType::REFUND_STATUS),
    			'vipList' =>  $this->findVipList(SysParameter::no),
    	]);
    }
    

    /**
     * Updates an existing RefundSheet model.
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
            return $this->render('update', [
                'model' => $model,
            		'merchantList' => $this->findVipList(SysParameter::yes),
            		'orderList' => $this->findSoSheetList(),
            		'returnList' => $this->findReturnSheetList(),
            		'refundApplyList' => $this->findRefundSheetApplyList(),
            		'userList' => $this->findSysUserList(),
            		'refundStatusList' => SysParameterType::getSysParametersById(SysParameterType::REFUND_STATUS),
            		'vipList' =>  $this->findVipList(SysParameter::no),
            ]);
        }
    }

    /**
     * Deletes an existing RefundSheet model.
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
     * Finds the RefundSheet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RefundSheet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = RefundSheet::find()->alias("refundSheet")
    	->joinWith("merchant merchant")
    	->joinWith("order order")
    	->joinWith("return return")
    	->joinWith("refundApply refundApply")
    	->joinWith("user user")
    	->joinWith("status0 stat")
    	->joinWith("vip vip")
    	->where(['refundSheet.id' => $id])->one();
    	
    	if($model){
//     	if (($model = RefundSheet::findOne($id)) !== null) {
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
    	return Vip::find()->where(['merchant_flag'=>$merchant_flag])->all();
    }
    
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findSoSheetList(){
    	return SoSheet::find()->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findReturnSheetList(){
    	return ReturnSheet::find()->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findRefundSheetApplyList(){
    	return RefundSheetApply::find()->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findSysUserList(){
    	return SysUser::find()->all();
    }
}
