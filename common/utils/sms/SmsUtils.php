<?php

namespace app\common\utils\sms;

use Yii;

/**
 * 短消息发送
 * @author Tiger-guo
 *
 */
class SmsUtils{
	
	public function send(){
		$this->send_ali_sms();
	}
	
	
	private function send_ali_sms(){
		/* Yii::$app->params['ali_sms']['appkey'];
		Yii::$app->params['ali_sms']['secretKey'];
		Yii::$app->params['ali_sms']['sms_free_sign_name']; */
		
		$c = new TopClient;
		$c->appkey = $appkey;
		$c->secretKey = $secret;
		$req = new AlibabaAliqinFcSmsNumSendRequest;
		$req->setExtend("123456");
		$req->setSmsType("normal");
		$req->setSmsFreeSignName("阿里大于");
		$req->setSmsParam("{\"code\":\"1234\",\"product\":\"alidayu\"}");
		$req->setRecNum("13000000000");
		$req->setSmsTemplateCode("SMS_585014");
		$resp = $c->execute($req);
		
		/*TODO: 解析返回xml得到结果  */
		$resp_arr = $this->xml_to_array($resp);
// 		Yii::info($req);
		
		return $resp_arr;
	}

	
	function xml_to_array($xml){
		$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
		if(preg_match_all($reg, $xml, $matches)){
			$count = count($matches[0]);
			for($i = 0; $i < $count; $i++){
				$subxml= $matches[2][$i];
				$key = $matches[1][$i];
				if(preg_match( $reg, $subxml )){
					$arr[$key] = xml_to_array( $subxml );
				}else{
					$arr[$key] = $subxml;
				}
			}
		}
		return $arr;
	}
	function random($length = 6 , $numeric = 0) {
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