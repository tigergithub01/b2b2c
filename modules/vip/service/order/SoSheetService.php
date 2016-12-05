<?php

namespace app\modules\vip\service\order;

use app\common\utils\CommonUtils;
use app\common\utils\UrlUtils;
use app\models\b2b2c\Vip;
use app\models\b2b2c\VipOrganization;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\SoSheetDetail;
use app\models\b2b2c\SoSheet;

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
}