<?php
namespace app\common\utils;

use Yii;

class ConfigUtils{
	
	public static function get_universal_sms_code(){
		return Yii::$app->params['universal_sms_code'];
	}
	
	
}