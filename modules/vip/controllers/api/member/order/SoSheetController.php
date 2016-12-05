<?php

namespace app\modules\vip\controllers\api\member\order;

use app\common\utils\CommonUtils;
use app\models\b2b2c\Activity;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\DeliveryTypeTpl;
use app\models\b2b2c\PayType;
use app\models\b2b2c\PickUpPoint;
use app\models\b2b2c\Product;
use app\models\b2b2c\search\SoSheetSearch;
use app\models\b2b2c\SheetType;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\SoSheetDetail;
use app\models\b2b2c\SoSheetVip;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysRegion;
use app\models\b2b2c\Vip;
use app\modules\vip\common\controllers\BaseAuthApiController;
use app\modules\vip\models\VipConst;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\common\utils\UrlUtils;
use app\models\b2b2c\VipOrganization;
use app\models\b2b2c\SysParameterType;
use app\modules\vip\service\order\SoSheetService;
use app\modules\vip\service\vip\VipService;
use app\modules\vip\service\vip\MerchantService;

/**
 * SoSheetController implements the CRUD actions for SoSheet model.
 */
class SoSheetController extends BaseAuthApiController {
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
	 * Lists all SoSheet models.
	 *
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new SoSheetSearch ();
		$searchModel->vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
		$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
		
		$models = $dataProvider->getModels ();
		
		// 格式化输出
		$soSheetService = new SoSheetService ();
		
		$pagionationObj = new PaginationObj ( $soSheetService->getSoSheetModelArray ( $models ), $dataProvider->getTotalCount () );
		return CommonUtils::json_success ( $pagionationObj );
	}
	
	/**
	 * Displays a single SoSheet model.
	 *
	 * @param string $id        	
	 * @return mixed
	 */
	public function actionView() {
		$id = isset ( $_REQUEST ['id'] ) ? $_REQUEST ['id'] : null;
		$vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
		
		$model = $this->findModel ( $id );
		
		if ($model->vip_id != $vip_id) {
			return CommonUtils::json_failed ( "非法查看订单，只能查看自己的订单！" );
		}
		
		// 订单明细
		$soSheetDetailList = $this->findSoSheetDetailList ( $id );
		
		// 格式化输出
		$soSheetService = new SoSheetService ();
		
		return CommonUtils::json_success ( [ 
				"model" => $soSheetService->getSoSheetModelArray ( $model ),
				'soSheetDetails' => $soSheetService->getSoSheetDetailModelArray ( $soSheetDetailList ) 
		] );
	}
	
	/**
	 * 普通订单-个人服务提交页面
	 * Creates a new SoSheet model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new SoSheet ();
		
		$model->order_quantity = 1;
		$model->goods_amt = 0;
		$model->order_amt = 0;
		
		if ($model->load ( Yii::$app->request->post () ) /* && $model->save() */) {
			$transaction = SoSheet::getDb ()->beginTransaction ();
			try {
				//初始化数据
				$model->integral = 0;
				$model->integral_money = 0;
				$model->coupon = 0;
				$model->discount = 0;
				$model->order_status = SoSheet::order_need_pay;
				$model->pay_status = SoSheet::pay_need_pay;
				$model->deliver_fee = 0;
				$model->vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
				$model->code = SheetType::getCode ( SheetType::so, true );
				$model->order_date = date ( VipConst::DATE_FORMAT, time () );
				
				if(empty($model->merchant_id)){
					return CommonUtils::json_failed ( '商户编号不能为空！' );
				}		
				
				$merchant = Vip::find ()->where ( [
						'id' => $model->merchant_id,
						'merchant_flag' => SysParameter::yes,
						'audit_status' => SysParameter::audit_approved
				] )->one ();
				if (empty ( $merchant )) {
					return CommonUtils::json_failed ( '商户不存在！' );
				}				
				
				if(empty($model->consignee)){
					return CommonUtils::json_failed ( '联系人不能为空！' );
				}
				
				if(empty($model->mobile)){
					return CommonUtils::json_failed ( '联系方式不能为空！' );
				}
				
				if(empty($model->service_date)){
					return CommonUtils::json_failed ( '服务日期不能为空！' );
				}
				
				//根据商户编号查询此商户对应的个人服务
				$product = $this->findProduct($merchant->id);
				
				/* 写订单明细 */
				$soSheetDetail = new SoSheetDetail ();
				$soSheetDetail->product_id = $product->id;
				$soSheetDetail->quantity = 1;
				$soSheetDetail->price = $product->sale_price;
				$soSheetDetail->amount = $soSheetDetail->quantity * $soSheetDetail->price;
				
				
				// 根据产品编号计算出订单总金额
				$model->goods_amt = $soSheetDetail->amount; //服务总金额
				$model->order_amt = $soSheetDetail->amount; //订单金额
				$model->deposit_amount = $product->deposit_amount; //定金金额
				
				/* 保存失败处理 */
				if (! ($model->save ())) {
					$transaction->rollBack ();
					return CommonUtils::jsonMsgObj_failed ( '订单提交失败！', $model );
				}
				
				$soSheetDetail->order_id = $model->id;
				if (! $soSheetDetail->save ()) {
					$transaction->rollBack ();
					return CommonUtils::jsonMsgObj_failed ( '订单提交失败！', $model );
				}
				
				/* 订单商户对应关系 */
				$vip_ids = $this->findVipIdList ( $model->id );
				
				// delete frist
				SoSheetVip::deleteAll ( [ 
						'order_id' => $model->id 
				] );
				// insert last
				foreach ( $vip_ids as $vip_id ) {
					$soSheetVip = new SoSheetVip ();
					$soSheetVip->vip_id = $vip_id;
					$soSheetVip->order_id = $model->id;
					if (! $soSheetVip->save ()) {
						$transaction->rollBack ();
						return CommonUtils::jsonMsgObj_failed ( '订单提交失败！', $model );
					}
				}
				
				$transaction->commit ();
				return CommonUtils::json_success ( $model->id );
			} catch ( \Exception $e ) {
				$transaction->rollBack ();
				$model->addError ( 'code', $e->getMessage () );
				return CommonUtils::jsonMsgObj_failed ( '订单提交失败！', $model );
			}
			
			return CommonUtils::json_success ( $model->id );
		} else {
			if ($model->load ( Yii::$app->request->get () )) {
				if(empty($model->merchant_id)){
					return CommonUtils::json_failed ( '商户编号不能为空！' );
				}
				
				$merchant = Vip::find ()->where ( [ 
						'id' => $model->merchant_id,
						'merchant_flag' => SysParameter::yes,
						'audit_status' => SysParameter::audit_approved 
				] )->one ();
				if (empty ( $merchant )) {
					return CommonUtils::json_failed ( '商户不存在！' );
				}
				
				//根据商户编号查询此商户对应的个人服务
				$product = $this->findProduct($merchant->id);
				
				// 根据产品编号计算出订单总金额
				$model->goods_amt = $product->sale_price * $model->order_quantity; // 服务总金额
				$model->order_amt = $product->sale_price * $model->order_quantity;  // 如果折扣有活动时，另外计算订单金额，TODO :		
				$model->deposit_amount = $product->deposit_amount; 
				
				$merchantService  = new MerchantService();
				return CommonUtils::json_success ( [ 
						'model' => $model,
						'merchant' => $merchantService->getMerchantModelArray($merchant),
						'product'  => $product,
						'vip' => \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER ) 
				] );
			} else {
				return CommonUtils::json_failed ( "参数非法！" );
			}
		}
		
		return $this->renderCreate ( $model );
	}
	
	/**
	 * 定制订单提交页面
	 * Creates a new SoSheet model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreatePackage() {
		
		// get request parameter sheet_type_id
		// $model->load(Yii::$app->request->get());
		// get parameters
		$activity_id = isset ( $_REQUEST ['activity_id'] ) ? $_REQUEST ['activity_id'] : null; // 购买团体服务
		if (empty ( $activity_id )) {
			throw new NotFoundHttpException ( Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		
		$model = new SoSheet ();
		$model->sheet_type_id = SheetType::so;
		$model->code = SheetType::getCode ( $model->sheet_type_id );
		$model->order_date = date ( VipConst::DATE_FORMAT, time () );
		$model->integral = 0;
		$model->integral_money = 0;
		$model->coupon = 0;
		$model->discount = 0;
		$model->order_status = SoSheet::order_need_pay;
		$model->pay_status = SoSheet::pay_need_pay;
		$model->deliver_fee = 0;
		$model->order_quantity = 1;
		$model->goods_amt = 0;
		$model->order_amt = 0;
		
		$vip_user = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER );
		$model->vip_id = $vip_user->id;
		$model->consignee = $vip_user->vip_name;
		$model->mobile = $vip_user->vip_id;
		
		// 根据团体服务编号计算出订单总金额
		$activity = Activity::findOne ( $activity_id );
		$model->goods_amt = $activity->package_price;
		$model->order_amt = $activity->package_price;
		
		if ($model->load ( Yii::$app->request->post () ) /* && $model->save() */) {
			
			$transaction = SoSheet::getDb ()->beginTransaction ();
			try {
				// 重新获取订单编号
				$model->code = SheetType::getCode ( $model->sheet_type_id, true );
				$model->order_date = date ( VipConst::DATE_FORMAT, time () );
				
				/* 保存失败处理 */
				if (! ($model->save ())) {
					$transaction->rollBack ();
					return $this->renderCreate ( $model, 'create-package' );
				}
				
				/* 写订单明细 */
				$soSheetDetail = new SoSheetDetail ();
				$soSheetDetail->order_id = $model->id;
				$soSheetDetail->package_id = $activity_id;
				$soSheetDetail->quantity = 1;
				$soSheetDetail->price = $activity->package_price;
				$soSheetDetail->amount = $soSheetDetail->quantity * $soSheetDetail->price;
				if (! $soSheetDetail->save ()) {
					$transaction->rollBack ();
					return $this->renderCreate ( $model, 'create-package' );
				}
				
				/* 订单商户对应关系 */
				$vip_ids = $this->findVipIdList ( $model->id );
				
				// delete frist
				SoSheetVip::deleteAll ( [ 
						'order_id' => $model->id 
				] );
				// insert last
				foreach ( $vip_ids as $vip_id ) {
					$soSheetVip = new SoSheetVip ();
					$soSheetVip->vip_id = $vip_id;
					$soSheetVip->order_id = $model->id;
					if (! $soSheetVip->save ()) {
						$transaction->rollBack ();
						return $this->renderCreate ( $model, 'create-package' );
					}
				}
				
				$transaction->commit ();
				return CommonUtils::json_success ( $model->id );
			} catch ( \Exception $e ) {
				$transaction->rollBack ();
				// $model->addError('code',$e->getMessage());
				return $this->renderCreate ( $model, 'create-package' );
			}
			
			return CommonUtils::json_success ( $model->id );
		} /*  else { */
		return $this->renderCreate ( $model, 'create-package' );
		/* } */
	}
	
	/**
	 * 订单咨询页面
	 * Creates a new SoSheet model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreateConsult() {
		
		// get request parameter sheet_type_id
		// $model->load(Yii::$app->request->get());
		// get parameters
		
		// if($model->load(Yii::$app->request->post())){
		$merchant_id = isset ( $_REQUEST ['merchant_id'] ) ? $_REQUEST ['merchant_id'] : null; // 订单咨询商户编号
		$merchant = Vip::find ()->where ( [ 
				'id' => $merchant_id,
				'merchant_flag' => SysParameter::yes 
		] )->one ();
		if (empty ( $merchant )) {
			return CommonUtils::json_failed ( '您咨询的商户不存在！' );
		}
		
		$merchant->img_url = UrlUtils::formatUrl ( $merchant->img_url );
		$merchant->thumb_url = UrlUtils::formatUrl ( $merchant->thumb_url );
		$merchant->img_original = UrlUtils::formatUrl ( $merchant->img_original );
		
		$model = new SoSheet ();
		
		if ($model->load ( Yii::$app->request->post () ) /* && $model->save() */) {
			
			$model->sheet_type_id = SheetType::sc;
			$model->code = SheetType::getCode ( $model->sheet_type_id );
			$model->order_date = date ( VipConst::DATE_FORMAT, time () );
			$model->integral = 0;
			$model->integral_money = 0;
			$model->coupon = 0;
			$model->discount = 0;
			$model->order_status = SoSheet::order_need_pay;
			$model->pay_status = SoSheet::pay_need_pay;
			$model->deliver_fee = 0;
			$model->order_quantity = 1;
			$model->goods_amt = 0;
			$model->order_amt = 0;
			$model->merchant_id = $merchant_id;
			
			$vip_user = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER );
			$model->vip_id = $vip_user->id;
			$model->consignee = $vip_user->vip_name;
			$model->mobile = $vip_user->vip_id;
			
			$transaction = SoSheet::getDb ()->beginTransaction ();
			try {
				// 重新获取订单编号
				$model->code = SheetType::getCode ( $model->sheet_type_id, true );
				$model->order_date = date ( VipConst::DATE_FORMAT, time () );
				
				/* 保存失败处理 */
				if (! ($model->save ())) {
					$transaction->rollBack ();
					return $this->renderCreate ( $model, 'create-consult' );
				}
				
				/* 订单商户对应关系 */
				// $vip_ids = $this->findVipIdList($model->id);
				$soSheetVip = new SoSheetVip ();
				$soSheetVip->vip_id = $merchant_id;
				$soSheetVip->order_id = $model->id;
				if (! $soSheetVip->save ()) {
					$transaction->rollBack ();
					return $this->renderCreate ( $model, 'create-consult' );
				}
				
				$transaction->commit ();
				return CommonUtils::json_success ( $model->id );
			} catch ( \Exception $e ) {
				$transaction->rollBack ();
				// $model->addError('code',$e->getMessage());
				return $this->renderCreate ( $model, 'create-consult' );
			}
			
			return CommonUtils::json_success ( $model->id );
		} else {
			$data = ArrayHelper::toArray ( $merchant, [ 
					Vip::className () => array_merge ( CommonUtils::getModelFields ( $merchant ), [ 
							'vip_type_name' => function ($value) {
								return (empty ( $value->vipType ) ? '' : $value->vipType->name);
							},
							'password' => function ($value) {
								// 密码设置为空
								return null;
							} 
					] ) 
			] );
			
			return CommonUtils::json_success ( [ 
					'merchant' => $data,
					'service_style_list' => SysParameterType::getSysParametersById ( SysParameterType::SERVICE_STYLE ),
					'related_service_list' => SysParameterType::getSysParametersById ( SysParameterType::RELATED_SERVICE ),
					'vip' => \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER ) 
			] );
		}
	}
	
	/**
	 *
	 * @return Ambigous <string, string>
	 */
	protected function renderCreate($model, $action = 'create') {
		return CommonUtils::jsonMsgObj_failed ( '订单提交失败！', $model );
	}
	
	/**
	 * Finds the SoSheet model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param string $id        	
	 * @return SoSheet the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		$model = SoSheet::find ()->alias ( "so" )->joinWith ( "vip vip" )->joinWith ( "city city" )->joinWith ( "country country" )->joinWith ( "deliveryStatus deliveryStatus" )->joinWith ( "district district" )->joinWith ( "invoiceType invoiceType" )->joinWith ( "orderStatus orderStatus" )->joinWith ( "payStatus payStatus" )->joinWith ( "province province" )->joinWith ( "deliveryType deliveryType" )->joinWith ( "payType payType" )->joinWith ( "pickPoint pickPoint" )->where ( [ 
				'so.id' => $id 
		] )->one ();
		
		if (empty ( $model )) {
			throw new NotFoundHttpException ( Yii::t ( 'app', 'The requested page does not exist.' ) );
		}
		
		return $model;
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
	protected function findSysRegionList($region_type, $parent_id = null) {
		return SysRegion::find ()->where ( [ 
				'region_type' => $region_type 
		] )->andFilterWhere ( [ 
				'parent_id' => $parent_id 
		] )->limit ( 100 )->offset ( 0 )->all ();
	}
	
	/**
	 *
	 * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
	 */
	protected function findPayTypeList() {
		return PayType::find ()->all ();
	}
	
	/**
	 *
	 * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
	 */
	protected function findDeliveryTypeList() {
		return DeliveryTypeTpl::find ()->all ();
	}
	
	/**
	 *
	 * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
	 */
	protected function findPickUpPointList() {
		return PickUpPoint::find ()->all ();
	}
	
	/**
	 *
	 * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
	 */
	protected function findSheetTypeList() {
		return SheetType::find ()->where ( [ 
				'id' => [ 
						SheetType::so,
						SheetType::sc 
				] 
		] )->all ();
	}
	
	/**
	 *
	 * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
	 */
	protected function findActivityList() {
		return Activity::find ()->all ();
	}
	
	/**
	 *
	 * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
	 */
	protected function findSoSheetList() {
		return SoSheet::find ()->all ();
	}
	
	/**
	 *
	 * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
	 */
	protected function findProductList() {
		return Product::find ()->all ();
	}
	
	/**
	 *
	 * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
	 */
	function findSoSheetDetailList($order_id) {
		$models = SoSheetDetail::find ()->alias ( 'soDetail' )->joinWith ( 'order order' )->joinWith ( 'package package' )->joinWith ( 'product product' )->joinWith ( 'product.vip prod_merchant' )->joinWith ( 'package.vip pkg_merchant' )->where ( [ 
				'soDetail.order_id' => $order_id 
		] )->all ();
		return $models;
	}
	
	/**
	 * 查询订单产品所关联的商户编号
	 *
	 * @param unknown $order_id        	
	 * @return unknown
	 */
	private function findVipIdList($order_id) {
		$query = new \yii\db\Query ();
		$query = SoSheetDetail::find ()->select ( "vip.id" )->alias ( "so_detail" )->joinWith ( "product.vip vip" )->where ( [ 
				'so_detail.order_id' => $order_id 
		] )->andWhere ( [ 
				'IS NOT',
				"so_detail.product_id",
				NULL 
		] )->distinct ();
		
		$query_package = new Query ();
		$query_package = SoSheetDetail::find ()->select ( "vip.id" )->alias ( "so_detail" )->joinWith ( "package.vip vip" )->where ( [ 
				'so_detail.order_id' => $order_id 
		] )->andWhere ( [ 
				'IS NOT',
				"so_detail.package_id",
				NULL 
		] )->distinct ();
		$query->union ( $query_package );
		$vip_ids = $query->column ();
		return $vip_ids;
	}
	
	
	/**
	 * findProduct
	 * @param unknown $id
	 * @return unknown
	 */
	protected function findProduct($vip_id)
	{
		$model = Product::find()
		->where(['vip_id'=>$vip_id, 'service_flag'=>SysParameter::yes])->one();
		return $model;
	}
	
	// /**
	// * 婚礼类型列表
	// * @return string
	// */
	// public function actionServiceStyle()
	// {
	// $value = SysParameterType::getSysParametersById(SysParameterType::SERVICE_STYLE);
	// return CommonUtils::json_success($value);
	// }
	
	// /**
	// * 婚礼类型列表
	// * @return string
	// */
	// public function actionRelatedService()
	// {
	// $value = SysParameterType::getSysParametersById(SysParameterType::RELATED_SERVICE);
	// return CommonUtils::json_success($value);
	// }
}
