<?php

namespace app\common\utils;

use Yii;
use yii\helpers\Json;
use app\models\b2b2c\common\JsonObj;


class CommonUtils{
	
	public static function jsonObj_failed($jsonObj,$model = null){
		if($model && $model->hasErrors()){
			$firstErrors = $model->getFirstErrors();
			$jsonObj->attributeErrors = $firstErrors;
			foreach ($firstErrors as $key => $value) {
				$jsonObj->message = $value;
				break;
			}
		}
		$jsonObj->status = false;
		return Json::encode($jsonObj) ;
	}
	
	public static function jsonObj_success($jsonObj){
		$jsonObj->status = true;
		if($jsonObj->message==null){
			$jsonObj->message='操作成功!';
		}
		return Json::encode($jsonObj) ;
	}
	
	public static function json_failed($message,$value=null,$attributeErrors=[], $err_code=null){
		return Json::encode(new JsonObj(false, $value, $message, $attributeErrors, $err_code)) ;
	}
	
	public static function jsonMsgObj_failed($message,$model = null){
		$jsonObj = new JsonObj(false, null, $message, null, null);
		return self::jsonObj_failed($jsonObj, $model);
	}

	public static function json_success($value, $message='操作成功!'){
		return Json::encode(new JsonObj(true, $value, $message));
	}
	
	public static function response_failed($message, $err_code=null){
		header("Content-type: text/html; charset=utf-8");
		if (Yii::$app->getRequest()->getIsAjax()) {
			echo self::json_failed($message,null,null,$err_code);
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