<?php

namespace app\modules\vip\service\vip;

use app\common\utils\CommonUtils;
use app\common\utils\UrlUtils;
use app\models\b2b2c\ActPackageProduct;
use app\models\b2b2c\Product;
use app\models\b2b2c\Vip;
use app\models\b2b2c\VipOrganization;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\Activity;

class ActivityService {
	
	/**
	 * 格式化model
	 *
	 * @param unknown $model        	
	 */
	public function getActivityModelArray($model) {
		$data = ArrayHelper::toArray ( $model, [ 
				Activity::className () => array_merge ( CommonUtils::getModelFields ( new Activity () ), [ 
						'vip_no' => function ($value) {
							return (empty ( $value->vip ) ? '' : $value->vip->vip_id);
						},
						'vip_name' => function ($value) {
							return (empty ( $value->vip ) ? '' : $value->vip->vip_name);
						},
						'vip_type_name' => function ($value) {
							return ((empty ( $value->vip ) || empty ( $value->vip->vipType )) ? '' : $value->vip->vipType->name);
						},
						'img_url' => function ($value) {
							return UrlUtils::formatUrl ( $value->img_url );
						},
						'thumb_url' => function ($value) {
							return UrlUtils::formatUrl ( $value->thumb_url );
						},
						'img_original' => function ($value) {
							return UrlUtils::formatUrl ( $value->img_original );
						},
						'vip_thumb_url' => function ($value) {
							return (empty ( $value->vip ) ? '' : UrlUtils::formatUrl ( $value->vip->thumb_url ));
						},
						'vip_img_url' => function ($value) {
							return (empty ( $value->vip ) ? '' : UrlUtils::formatUrl ( $value->vip->img_url ));
						},
						'vip_img_original' => function ($value) {
							return (empty ( $value->vip ) ? '' : UrlUtils::formatUrl ( $value->vip->img_original ));
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
	public function getActPackageProductModelArray($model) {
		$data = ArrayHelper::toArray ( $model, [ 
				ActPackageProduct::className () => array_merge ( CommonUtils::getModelFields ( new ActPackageProduct () ), [ 
						'vip_id' => function ($value) {
							return ((empty ( $value->product ) || empty ( $value->product->vip )) ? '' : $value->product->vip->id);
						},
						'vip_name' => function ($value) {
							return ((empty ( $value->product ) || empty ( $value->product->vip )) ? '' : $value->product->vip->vip_name);
						},
						'vip_type_name' => function ($value) {
							return ((empty ( $value->product ) || empty ( $value->product->vip ) || empty ( $value->product->vip->vipType )) ? '' : $value->product->vip->vipType->name);
						},
						'sale_price' => function ($value) {
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