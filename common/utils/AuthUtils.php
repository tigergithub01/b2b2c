<?php

namespace app\common\utils;

use Yii;


/**
 * 产生密钥
 * @author Tiger-guo
 *
 */
class AuthUtils{
	
	/**
	 * 
	 * @param unknown $uid
	 * @return unknown[]|number[]
	 */
	public function getAuthKey($uid){
		$appkey = Yii::$app->params['api_secret']['appkey'];
		
		$uid = $uid;
		$time = time();
		$key = md5($uid . $time . $appkey );
		
		
		return ['uid' => $uid, 'time' => $time, 'key' => $key ];
		
	}
	
	public function verifyKey($uid, $time ,$key){
		$appkey = Yii::$app->params['api_secret']['appkey'];
		
		//TODO:根据$time判断时间是否合法
		
		//判断key是否正确
		if($key!=md5($uid . $time. $appkey )){
			return false;
		}
		
		return true;		
	}
}