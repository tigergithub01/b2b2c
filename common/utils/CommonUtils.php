<?php

namespace app\common\utils;

use Yii;
use yii\helpers\Json;
use app\models\b2b2c\common\JsonObj;


class CommonUtils{
	
	public static function json_failed($message,$value=null,$attributeErrors=[]){
		return Json::encode(new JsonObj(false, $value, $message, $attributeErrors)) ;
	}

	public static function json_success($value, $message=null){
		return Json::encode(new JsonObj(true, $value, $message));
	}
	
	public static function response_failed($message){
		header("Content-type: text/html; charset=utf-8");
		if (Yii::$app->getRequest()->getIsAjax()) {
			echo $this::json_failed($message);
			exit;
		}else{
			echo $message;
			exit();
		}
	}
	
	public static function random($length = 6 , $numeric = 0) {
		PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
		if($numeric) {
			$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
		} else {
			$hash = '';
			$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
			$max = strlen($chars) - 1;
			for($i = 0; $i < $length; $i++) {
				$hash .= $chars[mt_rand(0, $max)];
			}
		}
		return $hash;
	}
}