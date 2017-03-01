<?php

namespace app\modules\vip\controllers\api\member\order;

use app\common\utils\CommonUtils;
use app\models\b2b2c\Activity;
use app\models\b2b2c\ActPackageProduct;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\DeliveryTypeTpl;
use app\models\b2b2c\PayType;
use app\models\b2b2c\PickUpPoint;
use app\models\b2b2c\Product;
use app\models\b2b2c\Quotation;
use app\models\b2b2c\QuotationDetail;
use app\models\b2b2c\search\SoSheetSearch;
use app\models\b2b2c\SheetLog;
use app\models\b2b2c\SheetType;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\SoSheetDetail;
use app\models\b2b2c\SoSheetPayInfo;
use app\models\b2b2c\SoSheetVip;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysRegion;
use app\models\b2b2c\Vip;
use app\modules\vip\common\controllers\BaseAuthApiController;
use app\modules\vip\models\VipConst;
use app\modules\vip\service\order\QuotationService;
use app\modules\vip\service\order\SoSheetService;
use app\modules\vip\service\vip\ActivityService;
use app\modules\vip\service\vip\MerchantService;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\common\utils\UrlUtils;
use app\common\utils\WxPayUtils;

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
	 * 普通订单- 确认提交
	 * Creates a new SoSheet model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate() {
		$merchantService = new MerchantService ();
		$model = new SoSheet ();
		
		$merchant_id = isset ( $_REQUEST ['merchant_id'] ) ? $_REQUEST ['merchant_id'] : null;
		if (empty ( $merchant_id )) {
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
		
		// 根据商户编号查询此商户对应的个人服务
		$product = $this->findProduct ( $merchant_id );
		if (empty ( $product )) {
			return CommonUtils::json_failed ( '服务不存在！' );
		}
		
		// 根据产品编号计算出订单总金额
		$model->order_quantity = 1;
		$model->goods_amt = $product->sale_price * $model->order_quantity; // 服务总金额
		$model->order_amt = $product->sale_price * $model->order_quantity; // 如果折扣有活动时，另外计算订单金额，TODO :
		$model->deposit_amount = $product->deposit_amount; // 定金
		
		if ($model->load ( Yii::$app->request->post () ) /* && $model->save() */) {
			$transaction = SoSheet::getDb ()->beginTransaction ();
			try {
				// 初始化数据
				$model->integral = 0;
				$model->integral_money = 0;
				$model->coupon = 0;
				$model->discount = 0;
				$model->order_status = SoSheet::order_need_pay;
				$model->pay_status = SoSheet::pay_need_pay;
				$model->deliver_fee = 0;
				$model->vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
				$model->code = SheetType::getCode ( SheetType::so, true );
				$model->order_date = \app\common\utils\DateUtils::formatDatetime();
				
				if (empty ( $model->consignee )) {
					return CommonUtils::json_failed ( '联系人不能为空！' );
				}
				
				if (empty ( $model->mobile )) {
					return CommonUtils::json_failed ( '联系方式不能为空！' );
				}
				
				if (empty ( $model->service_date )) {
					return CommonUtils::json_failed ( '服务日期不能为空！' );
				}
				
				/* 保存失败处理 */
				if (! ($model->save ())) {
					$transaction->rollBack ();
					return CommonUtils::jsonMsgObj_failed ( '订单提交失败！', $model );
				}
				
				/* 写订单明细 */
				$soSheetDetail = new SoSheetDetail ();
				$soSheetDetail->product_id = $product->id;
				$soSheetDetail->order_id = $model->id;
				$soSheetDetail->quantity = $model->order_quantity;
				$soSheetDetail->price = $product->sale_price;
				$soSheetDetail->amount = $soSheetDetail->quantity * $soSheetDetail->price;
				
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
		}
		
		return CommonUtils::json_success ( [ 
				'model' => $model,
				'merchant' => $merchantService->getMerchantModelArray ( $merchant ),
				'product' => $product,
				'vip' => \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER ) 
		] );
	}
	
	/**
	 * 团体服务 - 确认提交
	 * Creates a new SoSheet model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreatePackage() {
		$activityService = new ActivityService ();
		$model = new SoSheet ();
		
		$activity_id = isset ( $_REQUEST ['activity_id'] ) ? $_REQUEST ['activity_id'] : null;
		if (empty ( $activity_id )) {
			return CommonUtils::json_failed ( '团体服务不能为空！' );
		}
		
		$activity = Activity::find ()->where ( [ 
				'id' => $activity_id,
				'audit_status' => SysParameter::audit_approved 
		] )->one ();
		if (empty ( $activity )) {
			return CommonUtils::json_failed ( '团体服务不存在！' );
		}
		
		// 团体服务明细
		$actPackageProductList = $this->findActPackageProductList ( $activity_id );
		if (empty ( $actPackageProductList )) {
			return CommonUtils::json_failed ( '团体服务无明细！' );
		}
		
		// 根据团体服务计算出订单总金额
		$model->order_quantity = 1;
		$model->goods_amt = $activity->package_price * $model->order_quantity; // 服务总金额
		$model->order_amt = $activity->package_price * $model->order_quantity; // 如果折扣有活动时，另外计算订单金额，TODO :
		$model->deposit_amount = $activity->deposit_amount; // 定金
		
		if ($model->load ( Yii::$app->request->post () ) /* && $model->save() */) {
			$transaction = SoSheet::getDb ()->beginTransaction ();
			try {
				// 初始化数据
				$model->integral = 0;
				$model->integral_money = 0;
				$model->coupon = 0;
				$model->discount = 0;
				$model->order_status = SoSheet::order_need_pay;
				$model->pay_status = SoSheet::pay_need_pay;
				$model->deliver_fee = 0;
				$model->vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
				$model->code = SheetType::getCode ( SheetType::so, true );
				$model->order_date = \app\common\utils\DateUtils::formatDatetime();
				
				if (empty ( $model->consignee )) {
					return CommonUtils::json_failed ( '联系人不能为空！' );
				}
				
				if (empty ( $model->mobile )) {
					return CommonUtils::json_failed ( '联系方式不能为空！' );
				}
				
				if (empty ( $model->service_date )) {
					return CommonUtils::json_failed ( '服务日期不能为空！' );
				}
				
				/* 保存失败处理 */
				if (! ($model->save ())) {
					$transaction->rollBack ();
					return CommonUtils::jsonMsgObj_failed ( '订单提交失败！', $model );
				}
				
				/* 写订单明细 */
				$soSheetDetail = new SoSheetDetail ();
				$soSheetDetail->package_id = $activity->id;
				$soSheetDetail->order_id = $model->id;
				$soSheetDetail->quantity = $model->order_quantity;
				$soSheetDetail->price = $activity->package_price;
				$soSheetDetail->amount = $soSheetDetail->quantity * $soSheetDetail->price;
				
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
		}
		
		return CommonUtils::json_success ( [ 
				'model' => $model,
				'activity' => $activityService->getActivityModelArray ( $activity ),
				'actPackageProducts' => $activityService->getActPackageProductModelArray ( $actPackageProductList ),
				'vip' => \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER ) 
		] );
	}
	
	/**
	 * 订单咨询 - 确认提交
	 * Creates a new SoSheet model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreateQuotation() {
		$quotationService = new QuotationService ();
		$model = new SoSheet ();
		$vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
		
		$quotation_id = isset ( $_REQUEST ['quotation_id'] ) ? $_REQUEST ['quotation_id'] : null;
		if (empty ( $quotation_id )) {
			return CommonUtils::json_failed ( '咨询编号不能为空！' );
		}
		
		$quotation = Quotation::find ()->where ( [ 
				'id' => $quotation_id 
		] )->one ();
		if (empty ( $quotation )) {
			return CommonUtils::json_failed ( '订单咨询不存在！' );
		}
		
		if ($quotation->vip_id != $vip_id) {
			return CommonUtils::json_failed ( '非法操作！' );
		}
		
		if ($quotation->status != Quotation::stat_replied) {
			// 只有回复的订单咨询才能提交订单
			return CommonUtils::json_failed ( '非法操作，只有待回复的订单咨询才能提交订单！' );
		}
		
		// 咨询明细
		$quotationDetailList = $this->findQuotationDetailList ( $quotation_id );
		if (empty ( $quotationDetailList )) {
			return CommonUtils::json_failed ( '咨询无明细！' );
		}
		
		// 根据咨询计算出订单总金额
		$model->order_quantity = 1;
		$model->goods_amt = $quotation->order_amt * $model->order_quantity; // 服务总金额
		$model->order_amt = $quotation->order_amt * $model->order_quantity; // 如果折扣有活动时，另外计算订单金额，TODO :
		$model->deposit_amount = $quotation->deposit_amount; // 定金
		
		if ($model->load ( Yii::$app->request->post () ) /* && $model->save() */) {
			$transaction = SoSheet::getDb ()->beginTransaction ();
			try {
				// 初始化数据
				$model->integral = 0;
				$model->integral_money = 0;
				$model->coupon = 0;
				$model->discount = 0;
				$model->order_status = SoSheet::order_need_pay;
				$model->pay_status = SoSheet::pay_need_pay;
				$model->deliver_fee = 0;
				$model->vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
				$model->code = SheetType::getCode ( SheetType::so, true );
				$model->order_date = \app\common\utils\DateUtils::formatDatetime();
				$model->quotation_id = $quotation->id; // 订单咨询编号
				
				if (empty ( $model->consignee )) {
					return CommonUtils::json_failed ( '联系人不能为空！' );
				}
				
				if (empty ( $model->mobile )) {
					return CommonUtils::json_failed ( '联系方式不能为空！' );
				}
				
				if (empty ( $model->service_date )) {
					return CommonUtils::json_failed ( '服务日期不能为空！' );
				}
				
				/* 保存失败处理 */
				if (! ($model->save ())) {
					$transaction->rollBack ();
					return CommonUtils::jsonMsgObj_failed ( '订单提交失败！', $model );
				}
				
				/* 写订单明细 */
				foreach ( $quotationDetailList as $quotationDetail ) {
					$soSheetDetail = new SoSheetDetail ();
					$soSheetDetail->product_id = $quotationDetail->product->id;
					$soSheetDetail->order_id = $model->id;
					$soSheetDetail->quantity = $model->order_quantity;
					$soSheetDetail->price = $quotationDetail->price;
					$soSheetDetail->amount = $soSheetDetail->quantity * $soSheetDetail->price;
					
					if (! $soSheetDetail->save ()) {
						$transaction->rollBack ();
						return CommonUtils::jsonMsgObj_failed ( '订单提交失败！', $model );
					}
					;
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
				
				// 修改咨询单状态
				$quotation->status = Quotation::stat_effective; // 写入咨询状态
				$quotation->order_id = $model->id; // 写入关联订单编号
				if (! ($quotation->save ())) {
					$transaction->rollBack ();
					return CommonUtils::jsonMsgObj_failed ( '订单提交失败！', $model );
				}
				
				$transaction->commit ();
				return CommonUtils::json_success ( $model->id );
			} catch ( \Exception $e ) {
				$transaction->rollBack ();
				$model->addError ( 'code', $e->getMessage () );
				return CommonUtils::jsonMsgObj_failed ( '订单提交失败！', $model );
			}
			
			return CommonUtils::json_success ( $model->id );
		}
		
		return CommonUtils::json_success ( [ 
				'model' => $model,
				'quotation' => $quotationService->getQuotationModelArray ( $quotation ),
				'quotationDetailList' => $quotationService->getQuotationDetailModelArray ( $quotationDetailList ),
				'vip' => \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER ) 
		] );
	}
	
	/**
	 * 订单取消
	 *
	 * @return string
	 */
	public function actionCancel() {
		$model = new SoSheet ();
		$vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
		$order_id = isset ( $_REQUEST ['order_id'] ) ? $_REQUEST ['order_id'] : null;
		
		if (empty ( $order_id )) {
			return CommonUtils::json_failed ( '订单编号不能为空!' );
		}
		
		// 判断订单是否存在
		$model = $this->findModel ( $order_id );
		if (empty ( $model )) {
			return CommonUtils::json_failed ( '订单不存在!' );
		}
		
		if ($model->load ( Yii::$app->request->post () )) {
			$transaction = SoSheet::getDb ()->beginTransaction ();
			try {
				$soSheetService = new SoSheetService ();
				$jsonObj = $soSheetService->getSoSheetCancelAuth ( $model, $vip_id ); // 判断权限
				
				if (! ($jsonObj->status)) {
					return CommonUtils::json_failed ( $jsonObj->message );
				}
				
				$model->order_status = SoSheet::order_cancelled;
				$model->cancel_date = \app\common\utils\DateUtils::formatDatetime();
				if (! ($model->save ())) {
					$transaction->rollBack ();
					return CommonUtils::jsonMsgObj_failed ( '订单取消失败！', $model );
				}
				
				// 插入日志记录
				$sheetLog = new SheetLog ();
				$sheetLog->sheet_type_id = Sheettype::so;
				$sheetLog->ref_sheet_id = $model->id;
				$sheetLog->ref_sheet_code = $model->code;
				$sheetLog->action_date = \app\common\utils\DateUtils::formatDatetime();
				$sheetLog->vip_id = $vip_id;
				$sheetLog->description = "用户取消订单";
				if (! ($sheetLog->save ())) {
					$transaction->rollBack ();
					return CommonUtils::jsonMsgObj_failed ( '订单取消失败！', $model );
				}
				
				$transaction->commit ();
				return CommonUtils::json_success ( $model->id );
			} catch ( \Exception $e ) {
				$transaction->rollBack ();
				$model->addError ( 'code', $e->getMessage () );
				return CommonUtils::jsonMsgObj_failed ( '订单取消失败！', $model );
			}
		}
		
		return CommonUtils::jsonMsgObj_failed ( '订单取消失败！', $model );
	}
	
	/**
	 * 订单支付确认
	 *
	 * @return string
	 */
	public function actionPay() {
		$model = new SoSheet ();
		$vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
		$order_id = isset ( $_REQUEST ['order_id'] ) ? $_REQUEST ['order_id'] : null;
// 		$pay_type_code = isset ( $_REQUEST ['pay_type_code'] ) ? $_REQUEST ['pay_type_code'] : null;
		
		if (empty ( $order_id )) {
			return CommonUtils::json_failed ( '订单编号不能为空!' );
		}
		
		// 判断订单是否存在
		$model = $this->findModel ( $order_id );
		if (empty ( $model )) {
			return CommonUtils::json_failed ( '订单不存在!' );
		}
		
		$soSheetService = new SoSheetService ();
		$jsonObj = $soSheetService->getSoSheetPayAuth ( $model, $vip_id ); // 判断权限
		if (! ($jsonObj->status)) {
			return CommonUtils::json_failed ( $jsonObj->message );
		}
		
		// 格式化支付方式输出
		$data = ArrayHelper::toArray ( $this->findPayTypeList (), [ 
				PayType::className () => array_merge ( CommonUtils::getModelFields ( new PayType () ), [ 
						'configure' => function ($value) {
							return null;
						} 
				] ) 
		] );
		
		return CommonUtils::json_success ( [ 
				'model' => $model,
				'payTypeList' => $data,
				'payAmtList' => $soSheetService->getPayAmtInfo ( $model ) 
		] );
	}
	
	
	/**
	 * 请求调用支付
	 */
	/* public function actionPayReq(){
		$model = new SoSheet ();
		$order_id = isset ( $_REQUEST ['order_id'] ) ? $_REQUEST ['order_id'] : null; //订单编号
// 		$pay_type_code = isset ( $_REQUEST ['pay_type_code'] ) ? $_REQUEST ['pay_type_code'] : null; //支付方式
// 		$pay_amt = isset ( $_REQUEST ['pay_amt'] ) ? $_REQUEST ['pay_amt'] : null;//本次支付金额

		if (empty ( $order_id )) {
			return CommonUtils::json_failed ( '订单编号不能为空!' );
		}
		
		// 判断订单是否存在
		$model = $this->findModel ( $order_id );
		if (empty ( $model )) {
			return CommonUtils::json_failed ( '订单不存在!' );
		}
		
		//加载post数据
		$model->load ( Yii::$app->request->post () );
		
		
		//支付方式判断
		if (empty ( $model->pay_type_id )) {
			return CommonUtils::json_failed ( '支付方式编号不能为空!' );
		}
			
		$payType = PayType::findOne ( $model->pay_type_id );
		if (empty ( $payType )) {
			return CommonUtils::json_failed ( '支付方式不存在!' );
		}
		
		//支付金额判断
		if($model->pay_amt<=0){
			return CommonUtils::json_failed ( '支付金额不合法!' );
		}
			
		if ($model->order_amt < ($model->paid_amt + $model->pay_amt)) {
			return CommonUtils::json_failed ( '支付金额不合法!' );
		}
		
		
		//①、获取用户openid
		$tools = new \JsApiPay();
// 		$openId = $tools->GetOpenid();
		
		//②、统一下单
		$input = new \WxPayUnifiedOrder();
		$input->SetBody($model->vip->vip_name);
		$input->SetAttach($model->vip->vip_name);
		$input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee($model->pay_amt * 100 ); //单位为分
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url(UrlUtils::formatUrl("/vip/api/member/order/so-sheet/wx-pay-notify"));
// 		$input->SetTrade_type("JSAPI");
		$input->SetTrade_type("APP");
// 		$input->SetOpenid($openId);
		$order = \WxPayApi::unifiedOrder($input);
		if($order['return_code']=='FAIL'){
			return CommonUtils::json_failed("获取prepay_id失败：". $order['return_msg'],$order);
		}
		
// 		echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
// 		$this->printf_info($order);
		//WxPayJsApiPay
		$wxPayJsApiPay = new \WxPayJsApiPay();
		$wxPayJsApiPay = $tools->GetJsApiParameters($order, true);
		
		
		
		//获取共享收货地址js函数参数
		//$editAddress = $tools->GetEditAddressParameters();
		$parameters = $wxPayJsApiPay->getValues();
		$parameters['mch_id'] = $order['mch_id'];
		$parameters['prepay_id'] = $order['prepay_id'];
		
		return CommonUtils::json_success($parameters);
		
	} */
	
	
	/**
	 * 请求调用支付
	 */
	public function actionPayReq(){
		$model = new SoSheet ();
		$order_id = isset ( $_REQUEST ['order_id'] ) ? $_REQUEST ['order_id'] : null; //订单编号
		// 		$pay_type_code = isset ( $_REQUEST ['pay_type_code'] ) ? $_REQUEST ['pay_type_code'] : null; //支付方式
		// 		$pay_amt = isset ( $_REQUEST ['pay_amt'] ) ? $_REQUEST ['pay_amt'] : null;//本次支付金额
	
		if (empty ( $order_id )) {
			return CommonUtils::json_failed ( '订单编号不能为空!' );
		}
	
		// 判断订单是否存在
		$model = $this->findModel ( $order_id );
		if (empty ( $model )) {
			return CommonUtils::json_failed ( '订单不存在!' );
		}
	
		//加载post数据
		$model->load ( Yii::$app->request->post () );
	
	
		//支付方式判断
		if (empty ( $model->pay_type_id )) {
			return CommonUtils::json_failed ( '支付方式编号不能为空!' );
		}
			
		$payType = PayType::findOne ( $model->pay_type_id );
		if (empty ( $payType )) {
			return CommonUtils::json_failed ( '支付方式不存在!' );
		}
	
		//支付金额判断
		if($model->pay_amt<=0){
			return CommonUtils::json_failed ( '支付金额不合法!' );
		}
			
		if ($model->order_amt < ($model->paid_amt + $model->pay_amt)) {
			return CommonUtils::json_failed ( '支付金额不合法!' );
		}
	
		
		//微信支付
		$app_id = Yii::$app->params['wx_pay']['app_id'];
		$mch_id = Yii::$app->params['wx_pay']['mch_id'];
		$app_key = Yii::$app->params['wx_pay']['app_key'];
		
		
		$wxPayUtils = new WxPayUtils();
		// get prepay id
		$body = $model->vip->vip_name;
		$total_fee = $model->pay_amt * 100;
		$notify_url = UrlUtils::formatUrl("/vip/api/member/order/so-sheet-pay-notify/wx-notify");
		$response = $wxPayUtils->sendPayReq($model->code , $body, $total_fee, $notify_url);
		
		// send it to APP
		return CommonUtils::json_success($response);
	
	}
	
	
	/**
	 * 微信支付回调函数
	 */
	public function actionWxPayNotify(){
		$notify = new \PayNotifyCallBack();
		$notify->Handle(false); //TODO：如何将值返回到controller中
		return CommonUtils::json_success(null);
	}
	
	//打印输出数组信息
	function printf_info($data)
	{
		foreach($data as $key=>$value){
			echo "<font color='#00ff55;'>$key</font> : $value <br/>";
		}
	}
	
	/**
	 * 订单支付成功逻辑
	 *
	 * @return string
	 */
	public function actionPayCallback() {
		$model = new SoSheet ();
		$vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
		$order_id = isset ( $_REQUEST ['order_id'] ) ? $_REQUEST ['order_id'] : null;
// 		$pay_type_code = isset ( $_REQUEST ['pay_type_code'] ) ? $_REQUEST ['pay_type_code'] : null;
		
		if (empty ( $order_id )) {
			return CommonUtils::json_failed ( '订单编号不能为空!' );
		}
		
		// 判断订单是否存在
		$model = $this->findModel ( $order_id );
		if (empty ( $model )) {
			return CommonUtils::json_failed ( '订单不存在!' );
		}
		
		if ($model->load ( Yii::$app->request->post () )) {
			$transaction = SoSheet::getDb ()->beginTransaction ();
			try {
				
				if (empty ( $model->pay_type_id )) {
					return CommonUtils::json_failed ( '支付方式编号不能为空!' );
				}
				
				$payType = PayType::findOne ( $model->pay_type_id );
				if (empty ( $payType )) {
					return CommonUtils::json_failed ( '支付方式不存在!' );
				}
				
				$soSheetService = new SoSheetService ();
				$jsonObj = $soSheetService->getSoSheetPayAuth ( $model, $vip_id ); // 判断权限
				if (! ($jsonObj->status)) {
					return CommonUtils::json_failed ( $jsonObj->message );
				}
				
				if ($model->order_amt < ($model->paid_amt + $model->pay_amt)) {
					return CommonUtils::json_failed ( '支付金额不合法!' );
				}
				
				$model->order_status = SoSheet::order_need_schedule; // 待接单
				if ($model->order_amt > ($model->paid_amt + $model->pay_amt)) {
					$model->pay_status = SoSheet::pay_part_pay; // 部分支付
				} else {
					$model->pay_status = SoSheet::pay_completed; // 支付完成
				}
				$model->pay_date = \app\common\utils\DateUtils::formatDatetime(); // 最后一次支付时间
				$model->paid_amt = ($model->paid_amt + $model->pay_amt); // 更新已付款金额
				if (! ($model->save ())) {
					$transaction->rollBack ();
					return CommonUtils::jsonMsgObj_failed ( '订单支付失败！', $model );
				}
				
				// 插入支付记录
				$soSheetPayInfo = new SoSheetPayInfo ();
				$soSheetPayInfo->order_id = $model->id;
				$soSheetPayInfo->pay_type_id = $model->pay_type_id;
				$soSheetPayInfo->pay_amt = $model->pay_amt;
				$soSheetPayInfo->pay_date = $model->pay_date;
				if (! ($soSheetPayInfo->save ())) {
					$transaction->rollBack ();
					return CommonUtils::jsonMsgObj_failed ( '订单支付失败！', $soSheetPayInfo );
				}
				
				$transaction->commit ();
				return CommonUtils::json_success ( $model->id );
			} catch ( \Exception $e ) {
				$transaction->rollBack ();
				$model->addError ( 'code', $e->getMessage () );
				return CommonUtils::jsonMsgObj_failed ( '订单支付失败！', $model );
			}
		}
		
		return CommonUtils::jsonMsgObj_failed ( '订单支付失败！', $model );
	}
	
	/**
	 * 客户确认交易完成
	 *
	 * @return string
	 */
	public function actionDone() {
		$model = new SoSheet ();
		$vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
		$order_id = isset ( $_REQUEST ['order_id'] ) ? $_REQUEST ['order_id'] : null;
		
		if (empty ( $order_id )) {
			return CommonUtils::json_failed ( '订单编号不能为空!' );
		}
		
		// 判断订单是否存在
		$model = $this->findModel ( $order_id );
		if (empty ( $model )) {
			return CommonUtils::json_failed ( '订单不存在!' );
		}
		
		$transaction = SoSheet::getDb ()->beginTransaction ();
		try {
			
			$soSheetService = new SoSheetService ();
			$jsonObj = $soSheetService->getSoSheetDoneAuth ( $model, $vip_id ); // 判断权限
			if (! ($jsonObj->status)) {
				return CommonUtils::json_failed ( $jsonObj->message );
			}
			
			$model->done_date =  \app\common\utils\DateUtils::formatDatetime();
			$model->order_status = SoSheet::order_need_commented; // 待评价
			if (! ($model->save ())) {
				$transaction->rollBack ();
				return CommonUtils::jsonModel_failed ( $model );
			}
			
			// 插入订单日志
			$sheetLog = new SheetLog ();
			$sheetLog->sheet_type_id = Sheettype::so;
			$sheetLog->ref_sheet_id = $model->id;
			$sheetLog->ref_sheet_code = $model->code;
			$sheetLog->action_date = \app\common\utils\DateUtils::formatDatetime();
			$sheetLog->vip_id = $vip_id;
			$sheetLog->description = "客户确认订单完成";
			if (! ($sheetLog->save ())) {
				$transaction->rollBack ();
				return CommonUtils::jsonModel_failed ( $model );
			}
			
			$transaction->commit ();
			return CommonUtils::json_success ( $model->id );
		} catch ( \Exception $e ) {
			$transaction->rollBack ();
			$model->addError ( 'code', $e->getMessage () );
			return CommonUtils::jsonModel_failed ( $model );
		}
		
		return CommonUtils::jsonModel_failed ( $model );
	}
	
	/**
	 * 订单权限
	 *
	 * @return string
	 */
	public function actionAuth() {
		$model = new SoSheet ();
		$vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
		$order_id = isset ( $_REQUEST ['order_id'] ) ? $_REQUEST ['order_id'] : null;
		
		if (empty ( $order_id )) {
			return CommonUtils::json_failed ( '订单编号不能为空!' );
		}
		
		// 判断订单是否存在
		$model = $this->findModel ( $order_id );
		if (empty ( $model )) {
			return CommonUtils::json_failed ( '订单不存在!' );
		}
		
		if ($model->vip_id != $vip_id) {
			CommonUtils::json_failed ( "非法操作，只能操作自己的订单!" );
		}
		
		$soSheetService = new SoSheetService ();
		$cancel = $soSheetService->getSoSheetCancelAuth ( $model, $vip_id )->status;
		$pay = $soSheetService->getSoSheetPayAuth ( $model, $vip_id )->status;
		$comment = $soSheetService->getSoSheetCmtAuth ( $model, $vip_id )->status;
		$refund = $soSheetService->getSoSheetRefundApplyAuth ( $model, $vip_id )->status;
		$done = $soSheetService->getSoSheetDoneAuth ( $model, $vip_id )->status;
		
		return CommonUtils::json_success ( [ 
				'cancel' => $cancel,
				'pay' => $pay,
				'comment' => $comment,
				'refund' => $refund,
				'done' => $done 
		] );
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
	 *
	 * @param unknown $id        	
	 * @return unknown
	 */
	protected function findProduct($vip_id) {
		$model = Product::find ()->where ( [ 
				'vip_id' => $vip_id,
				'service_flag' => SysParameter::yes,
				'audit_status' => SysParameter::audit_approved 
		] )->one ();
		return $model;
	}
	
	/**
	 *
	 * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
	 */
	function findActPackageProductList($act_id) {
		$models = ActPackageProduct::find ()->alias ( 'actProd' )->joinWith ( 'act act' )->joinWith ( 'product product' )->joinWith ( 'product.vip vip' )->joinWith ( 'product.vip.vipType vipType' )->where ( [ 
				'actProd.act_id' => $act_id 
		] )->all ();
		
		return $models;
	}
	
	/**
	 *
	 * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
	 */
	function findQuotationDetailList($quotation_id) {
		$models = QuotationDetail::find ()->alias ( 'quotDetail' )->joinWith ( 'quotation quotation' )->joinWith ( 'product product' )->joinWith ( 'product.vip vip' )->joinWith ( 'product.vip.vipType vipType' )->where ( [ 
				'quotDetail.quotation_id' => $quotation_id 
		] )->all ();
		return $models;
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
