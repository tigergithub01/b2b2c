<?php

namespace app\modules\vip\service\order;

use app\models\b2b2c\SysParameter;
use app\models\b2b2c\Vip;
use yii\helpers\ArrayHelper;
use app\common\utils\CommonUtils;
use app\models\b2b2c\Quotation;
use app\common\utils\UrlUtils;
use app\models\b2b2c\VipOrganization;
use app\models\b2b2c\QuotationDetail;

class QuotationService {
	
	/**
	 * 格式化model
	 *
	 * @param unknown $model        	
	 */
	public function getQuotationModelArray($model) {
		$data = ArrayHelper::toArray ( $model, [ 
				Quotation::className () => array_merge ( CommonUtils::getModelFields ( new Quotation () ), [ 
						'merchant' => function ($value) {
							$merchant = $value->merchant;
							if ($value->merchant) {
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
						'order_code' => function ($value) {
							return (empty ( $value->order ) ? '' : $value->order->code);
						},
						'status_name' => function ($value) {
							return (empty ( $value->status0 ) ? '' : $value->status0->param_val);
						},
						'vip_name' => function ($value) {
							return (empty ( $value->vip ) ? '' : $value->vip->vip_name);
						},
						'service_style_name' => function ($value) {
							return (empty ( $value->serviceStyle ) ? '' : $value->serviceStyle->param_val);
						},
						'related_service_names' => function ($value) {
							$related_service_names = [ ];
							if ($value->related_services) {
								$related_service_names = [ ];
								foreach ( $value->related_services as $value ) {
									$related_service_names [] = SysParameter::findOne ( $value )->param_val;
								}
							}
							return implode ( "，", $related_service_names );
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
	public function getQuotationDetailModelArray($model) {
		$data = ArrayHelper::toArray ( $model, [ 
				QuotationDetail::className () => array_merge ( CommonUtils::getModelFields ( new QuotationDetail () ), [ 
						'vip_id' => function ($value) {
							return ((empty ( $value->product ) || empty ( $value->product->vip )) ? '' : $value->product->vip->id);
						},
						'vip_name' => function ($value) {
							return ((empty ( $value->product ) || empty ( $value->product->vip )) ? '' : $value->product->vip->vip_name);
						},
						'vip_type_name' => function ($value) {
							return ((empty ( $value->product ) || empty ( $value->product->vip ) || empty ( $value->product->vip->vipType )) ? '' : $value->product->vip->vipType->name);
						},
						'original_price' => function ($value) {
							return (empty ( $value->product ) ? '' : $value->product->sale_price);
						},
						'description' => function ($value) {
							$vipOrganization = VipOrganization::find ()->where ( [ 
									'vip_id' => $value->product->vip->id 
							] )->one ();
							return (empty ( $vipOrganization ) ? '' : $vipOrganization->description);
						},
						'thumb_url' => function ($value) {
							return ((empty ( $value->product ) || empty ( $value->product->vip )) ? '' : UrlUtils::formatUrl ( $value->product->vip->thumb_url ));
						},
						'img_url' => function ($value) {
							return ((empty ( $value->product ) || empty ( $value->product->vip )) ? '' : UrlUtils::formatUrl ( $value->product->vip->img_url ));
						},
						'img_original' => function ($value) {
							return ((empty ( $value->product ) || empty ( $value->product->vip )) ? '' : UrlUtils::formatUrl ( $value->product->vip->img_original ));
						} 
						
				] ) 
		] );
		
		return $data;
	}
}