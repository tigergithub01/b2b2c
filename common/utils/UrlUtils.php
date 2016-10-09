<?php
namespace app\common\utils;

use Yii;

class UrlUtils{
	
	public static function formatUrl($url){
		return Yii::$app->request->hostInfo . '/' . $url;
	}
	
	
}