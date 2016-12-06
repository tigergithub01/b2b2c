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
	public function getSoSheetPayAuth($model, $vip_id){
		$jsonObj = new JsonObj();
		$jsonObj->status = false;
	
		//只能操作自己的订单
		if($model->vip_id != $vip_id){
			$jsonObj->message = "非法操作，只能操作自己的订单!";
			return $jsonObj;
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
	 * 判断订单确认完成权限
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
}