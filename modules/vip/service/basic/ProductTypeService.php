<?php

namespace app\modules\vip\service\basic;

use app\common\utils\CommonUtils;
use app\models\b2b2c\ProductType;
use app\models\b2b2c\Vip;
use yii\helpers\ArrayHelper;

class ProductTypeService {
	
	/**
	 * 格式化model
	 *
	 * @param unknown $model        	
	 */
	public function getProductTypeModelArray($model) {
		$data = ArrayHelper::toArray ( $model, [
				ProductType::className () => array_merge ( CommonUtils::getModelFields ( new ProductType () ), [ 
						
				] ) 
		] );
		
		return $data;
	}
}