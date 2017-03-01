<?php

namespace app\modules\vip\controllers\api\member\order;

use app\common\utils\MsgUtils;
use app\models\b2b2c\RefundSheetApply;
use app\models\b2b2c\search\RefundSheetApplySearch;
use app\models\b2b2c\SheetType;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\Vip;
use app\modules\vip\common\controllers\BaseAuthApiController;
use app\modules\vip\models\VipConst;
use Yii;
use yii\web\NotFoundHttpException;
use app\common\utils\CommonUtils;
use app\models\b2b2c\common\PaginationObj;
use yii\helpers\ArrayHelper;
use app\modules\vip\service\order\RefundSheetApplyService;
use app\modules\vip\service\order\SoSheetService;

/**
 * RefundSheetApplyController implements the CRUD actions for RefundSheetApply model.
 */
class RefundSheetApplyController extends BaseAuthApiController {
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
	 * Lists all RefundSheetApply models.
	 * 
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new RefundSheetApplySearch ();
		$searchModel->vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
		$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
		
		$models = $dataProvider->getModels ();
		
		// 格式化输出
		$refundSheetApplyService = new RefundSheetApplyService ();
		$pagionationObj = new PaginationObj ( $refundSheetApplyService->getRefundSheetApplyModelArray ( $models ), $dataProvider->getTotalCount () );
		return CommonUtils::json_success ( $pagionationObj );
	}
	
	/**
	 * Displays a single RefundSheetApply model.
	 * 
	 * @param string $id        	
	 * @return mixed
	 */
	public function actionView($id) {
		$model = $this->findModel ( $id );
		
		$vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
		if ($model->vip_id != $vip_id) {
			return CommonUtils::json_failed ( "非法查看！" );
		}
		
		// 格式化输出
		$refundSheetApplyService = new RefundSheetApplyService ();
		return CommonUtils::json_success ( $refundSheetApplyService->getRefundSheetApplyModelArray ( $model ) );
	}
	
	/**
	 * Creates a new RefundSheetApply model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @return mixed
	 */
	public function actionCreate() {
		$vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
		
		$model = new RefundSheetApply ();
		$model->sheet_type_id = SheetType::ra;
		$model->apply_date = \app\common\utils\DateUtils::formatDatetime();
		$model->code = SheetType::getCode ( $model->sheet_type_id );
		$model->status = RefundSheetApply::status_need_confirm;
		$model->vip_id = $vip_id;
		
		if ($model->load ( Yii::$app->request->post () )/*  && $model->save() */) {
			
			$transaction = RefundSheetApply::getDb ()->beginTransaction ();
			try {
				
				if(empty($model->order_id)){
					return CommonUtils::json_failed("订单编号不能为空！");
				}
					
				$order = SoSheet::findOne($model->order_id);
				if(empty($order)){
					return CommonUtils::json_failed("订单不存在！");
				}				
				
				$soSheetService = new SoSheetService ();
				$jsonObj = $soSheetService->getSoSheetRefundApplyAuth ( $order, $vip_id ); // 判断权限
				if (! ($jsonObj->status)) {
					return CommonUtils::json_failed ( $jsonObj->message );
				}
				
				// 重新获取订单编号
// 				$model->code = SheetType::getCode ( $model->sheet_type_id, true );
				
				/* 保存失败处理 */
				if (! ($model->save ())) {
					$transaction->rollBack ();
					return $this->renderCreate ( $model );
				}
				
				$transaction->commit ();
				
				return CommonUtils::json_success ( $model->id );
			} catch ( \Exception $e ) {
				$transaction->rollBack ();
				$model->addError ( 'code', $e->getMessage () );
				return $this->renderCreate ( $model );
			}
			
			return CommonUtils::json_success ( $model->id );
		} else {
			return $this->renderCreate ( $model );
		}
	}
	protected function renderCreate($model) {
		return CommonUtils::jsonModel_failed ( $model );
	}
	
	/**
	 * Finds the RefundSheetApply model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * 
	 * @param string $id        	
	 * @return RefundSheetApply the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		$model = RefundSheetApply::find ()->alias ( "refundApply" )->joinWith ( "vip vip" )->joinWith ( "order order" )->joinWith ( "status0 stat" )->where ( [ 
				'refundApply.id' => $id 
		] )->one ();
		
		if ($model) {
			// if (($model = RefundSheetApply::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
	}
	
	/**
	 *
	 * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
	 */
	protected function findVipList($merchant_flag) {
		return Vip::find ()->where ( [ 
				'merchant_flag' => $merchant_flag 
		] )->all ();
	}
	
	/**
	 *
	 * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
	 */
	protected function findSoSheetList() {
		return SoSheet::find ()->all ();
	}
}
