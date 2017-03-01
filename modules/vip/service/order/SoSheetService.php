<?php

namespace app\modules\vip\service\order;

use app\common\utils\CommonUtils;
use app\common\utils\UrlUtils;
use app\models\b2b2c\Vip;
use app\models\b2b2c\VipOrganization;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\SoSheetDetail;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\common\JsonObj;
use app\models\b2b2c\RefundSheetApply;
use app\models\b2b2c\PayType;
use app\models\b2b2c\SoSheetPayInfo;

class SoSheetService {
	
	/**
	 * 格式化model
	 *
	 * @param unknown $model        	
	 */
	public function getSoSheetDetailModelArray($model) {
		$data = ArrayHelper::toArray ( $model, [ 
				SoSheetDetail::className () => array_merge ( CommonUtils::getModelFields ( new SoSheetDetail () ), [ 
						'merchant' => function ($value) {
							// 统一获取商户信息
							$merchant = null;
							$merchant_tmp = null;
							if ($value->product_id) {
								$merchant = $value->product->vip;
							} else if ($value->package_id) {
								$merchant = $value->package->vip;
							}
							
							if ($merchant) {
								$merchant_tmp = new Vip ();
								$merchant_tmp->id = $merchant->id;
								$merchant_tmp->vip_id = $merchant->vip_id;
								$merchant_tmp->vip_name = $merchant->vip_name;
								$merchant_tmp->thumb_url = UrlUtils::formatUrl ( $merchant->thumb_url );
								$merchant_tmp->img_url = UrlUtils::formatUrl ( $merchant->img_url );
								$merchant_tmp->img_original = UrlUtils::formatUrl ( $merchant->img_original );
							}
							
							// 商户类型
							$vip_type_name = (empty ( $merchant ) || empty ( $merchant->vipType )) ? '' : $merchant->vipType->name;
							
							// 营业描述
							$vip_org_desc = null;
							if ($merchant) {
								$vipOrg = VipOrganization::find ()->where ( [ 
										'vip_id' => $merchant->id 
								] )->one ();
								$vip_org_desc = empty ( $vipOrg ) ? null : $vipOrg->description;
							}
							
							return [ 
									'model' => $merchant_tmp,
									'vip_type_name' => $vip_type_name,
									'vip_org_desc' => $vip_org_desc 
							];
						},
						'package' => function ($value) {
							// 组合服务信息
							if ($value->package) {
								$value->package->thumb_url = UrlUtils::formatUrl ( $value->package->thumb_url );
								$value->package->img_url = UrlUtils::formatUrl ( $value->package->img_url );
								$value->package->img_original = UrlUtils::formatUrl ( $value->package->img_original );
							}
							return $value->package;
						},
						'product' => function ($value) {
							// 产品服务
							return $value->product;
						} 
				] ) 
		] );
		
		return $data;
	}
	
	/**
	 * 格式化model
	 *
	 * @param unknown $model        	
	 */
	public function getSoSheetModelArray($model) {
		$data = ArrayHelper::toArray ( $model, [ 
				SoSheet::className () => array_merge ( CommonUtils::getModelFields ( new SoSheet() ), [ 
						'order_status_name' => function ($value) {
							return (empty ( $value->orderStatus ) ? '' : $value->orderStatus->param_val);
						},
						'pay_status_name' => function ($value) {
							return (empty ( $value->payStatus ) ? '' : $value->payStatus->param_val);
						},
						'vip_name' => function ($value) {
							return (empty ( $value->vip ) ? '' : $value->vip->vip_name);
						} 
				] ) 
		] );
		
		return $data;
	}
	
	/**
	 * 判断订单取消权限
	 * @param unknown $model
	 * @param unknown $vip_id
	 * @return string
	 */
	public function getSoSheetCancelAuth($model, $vip_id){
		$jsonObj = new JsonObj();
		$jsonObj->status = false;
		
		//只能操作自己的订单
		if($model->vip_id != $vip_id){
			$jsonObj->message = "非法操作，只能操作自己的订单!";
			return $jsonObj;
		}
		
		//只有未付款的订单才可以取消
		if($model->order_status != SoSheet::order_need_pay){
			$jsonObj->message = "只有未付款的订单才可以取消!";
			return $jsonObj;
		}
		
		//成功
		$jsonObj->status = true;
		return $jsonObj;
	}
	
	/**
	 * 判断订单支付权限
	 * @param unknown $model
	 * @param unknown $vip_id
	 * @return \app\models\b2b2c\common\JsonObj
	 */
	public function getSoSheetPayAuth($model, $vip_id = null){
		$jsonObj = new JsonObj();
		$jsonObj->status = false;
	
		//只能操作自己的订单
		if($vip_id){
			if($model->vip_id != $vip_id){
				$jsonObj->message = "非法操作，只能操作自己的订单!";
				return $jsonObj;
			}
		}
	
		//“待付款，待接单，待服务,交易成功”状态下用户可以付款
		if(!($model->order_status == SoSheet::order_need_pay || 
				$model->order_status == SoSheet::order_need_schedule ||
				$model->order_status == SoSheet::order_need_service || 
				$model->order_status == SoSheet::order_completed)){
			$jsonObj->message = "订单在该状态不能付款!";
			return $jsonObj;
		}
		
		if($model->order_amt <= $model->paid_amt){
			$jsonObj->message = "订单已经付款完成，不能付款!";
			return $jsonObj;
		}			
	
		//成功
		$jsonObj->status = true;
		return $jsonObj;
	}
	
	/**
	 * 判断订单客户确认完成权限
	 * @param unknown $model
	 * @param unknown $vip_id
	 * @return \app\models\b2b2c\common\JsonObj
	 */
	public function getSoSheetDoneAuth($model, $vip_id){
		$jsonObj = new JsonObj();
		$jsonObj->status = false;
	
		//只能操作自己的订单
		if($model->vip_id != $vip_id){
			$jsonObj->message = "非法操作，只能操作自己的订单!";
			return $jsonObj;
		}
	
		//“交易成功”状态下用户可以确认完成
		if(!($model->order_status == SoSheet::order_completed)){
					$jsonObj->message = "商户确认服务完成后，才能确认交易完成!";
					return $jsonObj;
		}
	
		if($model->order_amt > $model->paid_amt){
			$jsonObj->message = "订单未付款完成，不能确认交易完成!";
			return $jsonObj;
		}
	
		//成功
		$jsonObj->status = true;
		return $jsonObj;
	}
	
	
	/**
	 * 判断订单评价权限
	 * @param unknown $model
	 * @param unknown $vip_id
	 * @return \app\models\b2b2c\common\JsonObj
	 */
	public function getSoSheetCmtAuth($model, $vip_id){
		$jsonObj = new JsonObj();
		$jsonObj->status = false;
	
		//只能操作自己的订单
		if($model->vip_id != $vip_id){
			$jsonObj->message = "非法操作，只能操作自己的订单!";
			return $jsonObj;
		}
	
		//“交易成功”状态下用户可以确认完成
		if(!($model->order_status == SoSheet::order_need_commented)){
			$jsonObj->message = "订单确认服务完成后，才能评价!";
			return $jsonObj;
		}
	
		//成功
		$jsonObj->status = true;
		return $jsonObj;
	}
	
	
	/**
	 * 判断订单申请退款权限
	 * @param unknown $model
	 * @param unknown $vip_id
	 * @return \app\models\b2b2c\common\JsonObj
	 */
	public function getSoSheetRefundApplyAuth($model, $vip_id){
		$jsonObj = new JsonObj();
		$jsonObj->status = false;
	
		//只能操作自己的订单
		if($model->vip_id != $vip_id){
			$jsonObj->message = "非法操作，只能操作自己的订单!";
			return $jsonObj;
		}
		
		if ($model->return_amt >0 && $model->return_date ){
			$jsonObj->message = "已经退款，不能重复申请!";
			return $jsonObj;
		}
	
		//“交易成功”状态下用户可以确认完成
		if($model->paid_amt > 0 && (($model->order_status == SoSheet::order_need_schedule || $model->order_status == SoSheet::order_need_service || SoSheet::order_completed ))){
			//已经付款，才可以申请付款
		}else{
			$jsonObj->message = "非法操作，已经付款的订单才可以申请退款!";
		}
		
		//已经申请退款的不可以多次申请
		$count = RefundSheetApply::find()->where(['order_id'=>$model->id,'status'=>[RefundSheetApply::status_need_confirm,
				RefundSheetApply::status_approved,RefundSheetApply::status_refund,RefundSheetApply::status_need_approve ]])->count();
		if($count>0){
			$jsonObj->message = "非法操作，退款处理中!";
			return $jsonObj;
		}
		
		//成功,
		$jsonObj->status = true;
		return $jsonObj;
	}
	
	
	/**
	 * 查找订单信息
	 * @param unknown $id
	 * @return \yii\db\ActiveRecord|NULL
	 */
	protected function findModel($id) {
		$model = SoSheet::find ()->alias ( "so" )->joinWith ( "vip vip" )->joinWith ( "city city" )->joinWith ( "country country" )->joinWith ( "deliveryStatus deliveryStatus" )->joinWith ( "district district" )->joinWith ( "invoiceType invoiceType" )->joinWith ( "orderStatus orderStatus" )->joinWith ( "payStatus payStatus")->joinWith ( "province province" )->joinWith ( "deliveryType deliveryType" )->joinWith ( "payType payType" )->joinWith ( "pickPoint pickPoint" )->where ( [
				'so.id' => $id
		] )->one ();
	
		return $model;
	}
	
	
	/**
	 * 获取订单可支付金额情况（定金，全款，尾款）
	 * @param unknown $model
	 * @return string[]|string[][]
	 */
	public function getPayAmtInfo($model) {
		$model =  empty($model)?(new SoSheet()):$model;
		$deposit_amt = 0; //定金
		$order_amt = 0; //全款
		$balance_amt = 0; //尾款
		
		if($model->paid_amt==0){
			//未支付
			if($model->deposit_amount>0){
				//需要支付定金
				$deposit_amt = $model->deposit_amount;
				$order_amt =  $model->order_amt;
			}else{
				//不需要支付定金
				$order_amt =  $model->order_amt;
			}
		}else{
			//已支付,支付尾款
			$balance_amt = $model->order_amt - $model->paid_amt;
		}
		
				
		return [ 
				'deposit_amt' => [ 
						'name' => '定金金额',
						'value' => $deposit_amt, 
				],
				'order_amt' => [ 
						'name' => '全款金额',
						'value' => $order_amt,
				],
				'balance_amt' => [ 
						'name' => '尾款金额',
						'value' => $balance_amt, 
				],
		];
	}
	
	/**
	 * 订单支付成功逻辑
	 * TODO:需要考虑定金支付为微信，尾款支付为支付宝的情况
	 * @param unknown $order_id
	 * @param unknown $pay_amt
	 * @param unknown $pay_type_id
	 * @param unknown $order_code
	 * @return \app\models\b2b2c\common\JsonObj
	 */
	public function soSheetPay($pay_amt, $pay_type_id, $order_id = null, $order_code = null) {
		$jsonObj = new JsonObj(false);
// 		$model = new SoSheet ();
		// 		$vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
// 		$order_id = isset ( $_REQUEST ['order_id'] ) ? $_REQUEST ['order_id'] : null;
		// 		$pay_type_code = isset ( $_REQUEST ['pay_type_code'] ) ? $_REQUEST ['pay_type_code'] : null;
	
		$model = null; //SoSheet，订单信息
		if($order_code){
			$model = SoSheet::find()->where(['code'=>$order_code])->one();
		}else{
			$model = $this->findModel ( $order_id );
		}
	
		// 判断订单是否存在
		if (empty ( $model )) {
			$jsonObj->message = '订单不存在!' ;
			return $jsonObj;
		}
		
		//重新设置支付方式与支付金额
		$model->pay_type_id = $pay_type_id;
		$model->pay_amt = $pay_amt;
		
		//插入支付数据
		$transaction = SoSheet::getDb ()->beginTransaction ();
		try {

			if (empty ( $model->pay_type_id )) {
				$jsonObj->message = '支付方式编号不能为空!' ; 
				return $jsonObj;
			}
			
			$payType = PayType::findOne ( $model->pay_type_id );
			if (empty ( $payType )) {
				$jsonObj->message = '支付方式不存在!' ;
				return $jsonObj;
			}

			$jsonObj = $this->getSoSheetPayAuth ( $model ); // 判断权限
			if (! ($jsonObj->status)) {
				$jsonObj->message = $jsonObj->message ;
				return $jsonObj;
			}

			if ($model->order_amt < ($model->paid_amt + $model->pay_amt)) {
				$jsonObj->message = '支付金额不合法!' ;
				return $jsonObj;
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
				$jsonObj->status = false;
				$jsonObj->message =  '订单状态修改失败！'+ CommonUtils::getModelFirstError($model);
				return $jsonObj;
			}
			
			// 插入支付记录
			$soSheetPayInfo = new SoSheetPayInfo ();
			$soSheetPayInfo->order_id = $model->id;
			$soSheetPayInfo->pay_type_id = $model->pay_type_id;
			$soSheetPayInfo->pay_amt = $model->pay_amt;
			$soSheetPayInfo->pay_date = $model->pay_date;
			if (! ($soSheetPayInfo->save ())) {
				$transaction->rollBack ();
				$jsonObj->message = '订单支付记录插入失败！' + CommonUtils::getModelFirstError($soSheetPayInfo);
				return $jsonObj;
			}
			
			$transaction->commit ();
			
			//支付成功
			$jsonObj->status = true;
			$jsonObj->message = '订单支付成功！';
			return $jsonObj; 
		} catch ( \Exception $e ) {
			$transaction->rollBack ();
			$model->addError ( 'code', $e->getMessage () );
			$jsonObj->message = '订单支付失败！' + $e->getMessage ();
			return $jsonObj;
		}
			
		$jsonObj->message = '订单支付失败！' + CommonUtils::getModelFirstError($model);
		return $jsonObj;
	}
}