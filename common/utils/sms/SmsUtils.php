<?php



namespace app\common\utils\sms;

use Yii;
use TopClient;
use AlibabaAliqinFcSmsNumSendRequest;

/**
 * 短消息发送
 * @author Tiger-guo
 *
 */
class SmsUtils{
	
	/**
	 * 发送短消息
	 * @param unknown $phone_number
	 * @param unknown $sms_code
	 * return ['status'=>true, 'msg'=> ''];
	 */
	public function sendSms($phone_number, $sms_code){
		return $this->send_ali_sms($phone_number, $sms_code);
	}
	
	/* 
	
	失败返回代码：
	{"code":"29","msg":"Invalid app Key","sub_code":"isv.appkey-not-exists","request_id":"uahms41a7ny"}
	
	 成功返回代码：
	{"result":{"err_code":"0","model":"103343447786^1104238917796","success":"true"},"request_id":"2ew2mwhm6vzi"}
	 */
	private function send_ali_sms($phone_number, $sms_code){
		$appkey = Yii::$app->params['ali_sms']['appkey'];
		$secret = Yii::$app->params['ali_sms']['secretKey'];
		$sms_free_sign_name = Yii::$app->params['ali_sms']['sms_free_sign_name'];
		$sms_template_code =  Yii::$app->params['ali_sms']['sms_template_code'];
		
		$c = new TopClient;
		$c->appkey = $appkey;
		$c->secretKey = $secret;
		$req = new AlibabaAliqinFcSmsNumSendRequest;
// 		$req->setExtend("123456");
		$req->setSmsType("normal");
		$req->setSmsFreeSignName($sms_free_sign_name);
		$req->setSmsParam("{\"number\":\"$sms_code\"}");
		$req->setRecNum($phone_number);
		$req->setSmsTemplateCode($sms_template_code);
		$resp = $c->execute($req);
		
		/*TODO: 解析返回xml得到结果  */
		Yii::info($resp);
		Yii::info(json_encode($resp));
		
		/* 转换xml为stdclass */
		$resp_obj = json_decode(json_encode($resp));
		$resp_result = ['status'=>false, 'msg'=> ''];
		if(property_exists($resp_obj, 'result')){
			//{"result":{"err_code":"0","model":"103343447786^1104238917796","success":"true"},"request_id":"2ew2mwhm6vzi"}
			if($resp_obj->result->err_code=='0' && $resp_obj->result->success){
				$resp_result= ['status'=>true, 'msg'=> ''];
			}
		}else{
			//{"code":"29","msg":"Invalid app Key","sub_code":"isv.appkey-not-exists","request_id":"uahms41a7ny"}
			$resp_result= ['status'=>false, 'msg'=> ($resp_obj->code .':' .$resp_obj->msg)];
		}
		
		return $resp_result;
	}

	
	function xml_to_array($xml){
		$arr=[];
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