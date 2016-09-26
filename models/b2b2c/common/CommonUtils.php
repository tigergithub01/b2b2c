<?php

namespace app\models\b2b2c\common;

use Yii;
use yii\helpers\Json;


class CommonUtils{

	public static function json_failed($message,$value=null){
		return Json::encode(new JsonObj(false, $value, $message)) ;
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
}