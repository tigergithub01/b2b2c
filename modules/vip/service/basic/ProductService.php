<?php

namespace app\modules\vip\service\basic;

use app\common\utils\CommonUtils;
use app\models\b2b2c\Product;
use app\models\b2b2c\Vip;
use yii\helpers\ArrayHelper;
use app\common\utils\UrlUtils;

class ProductService {
	
	/**
	 * 格式化model
	 *
	 * @param unknown $model        	
	 */
	public function getProductModelArray($model) {
		$data = ArrayHelper::toArray ( $model, [ 
				Product::className () => array_merge ( CommonUtils::getModelFields ( new Product () ), [ 
						'img_url' => function ($value) {
							return UrlUtils::formatUrl ( $value->img_url );
						},
						'thumb_url' => function ($value) {
							return UrlUtils::formatUrl ( $value->thumb_url );
						},
						'img_original' => function ($value) {
							return UrlUtils::formatUrl ( $value->img_original );
						},						
				] ) 
		] );
		
		return $data;
	}
}