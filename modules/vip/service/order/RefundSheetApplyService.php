<?php

namespace app\modules\vip\service\order;

use app\common\utils\CommonUtils;
use app\models\b2b2c\RefundSheetApply;
use app\models\b2b2c\Vip;
use yii\helpers\ArrayHelper;

class RefundSheetApplyService {
	
	/**
	 * 格式化model
	 *
	 * @param unknown $model        	
	 */
	public function getRefundSheetApplyModelArray($model) {
		$data = ArrayHelper::toArray ( $model, [ 
				RefundSheetApply::className () => array_merge ( CommonUtils::getModelFields ( new RefundSheetApply () ), [ 
						'status_name' => function ($value) {
							return (empty ( $value->status0 ) ? '' : $value->status0->param_val);
						},
						'order' => function ($value) {
							return $value->order;
						} 
				] ) 
		] );
		
		return $data;
	}
}