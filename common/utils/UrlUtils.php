<?php
namespace app\common\utils;

use Yii;

class UrlUtils{
	
	public static function formatUrl($url){
		if(!empty($url)){
			return Yii::$app->request->hostInfo . '/' . $url;
		}else {
			return $url;
		}
		
	}
	
	
}