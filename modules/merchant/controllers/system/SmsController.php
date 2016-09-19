<?php

namespace app\modules\merchant\controllers\system;

use Yii;
use yii\filters\AccessControl;
use app\modules\merchant\common\controllers\BaseController;
use app\modules\merchant\models\MerchantConst;
use yii\helpers\Json;
use app\models\b2b2c\SysParameter;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\common\JsonObj;
use app\models\b2b2c\SysVerifyCode;
use app\models\b2b2c\app\models\b2b2c;

/**
 * 获取短信验证码
 * 
 * @author Tiger-guo
 *        
 */
class SmsController extends BaseController {
	public $layout = "main-login";	
	
	/* public function behaviors() {
		return array_merge ( [ 
				'access' => [ 
						'class' => AccessControl::className (),
						'only' => ['logout'],
						'rules' => [ 
								[ 
										'actions' => [ 
												'logout' 
										],
										'allow' => true 
								] 
						] 
				] 
		], parent::behaviors () );
	} */
	
	/**
	 * Renders the index view for the module
	 * 
	 * @return string
	 */
	public function actionIndex() {
		$json = new JsonObj();
		$json->status = false;
		
		$session = Yii::$app->session;
		$request = Yii::$app->request;
		$req_verify_code =  $request->post('verify_code');
		$vip_id =  $request->post('vip_id');
		
		/* $req_verify_code =  isset($_REQUEST['verify_code'])?$_REQUEST['verify_code']:null;
		$vip_id =  isset($_REQUEST['vip_id'])?$_REQUEST['vip_id']:null; */

		//手机号码是否为空
		if(empty($vip_id)){
			$json->message = '手机号码不能为空！';
			return Json::encode($json);
		}
		
		//手机号码格式不正确
		$preg = '/^1[0-9]{10}$/'; 
		if (!preg_match($preg, $vip_id)) {
			$json->message = '手机号码格式不正确！';
			return Json::encode($json);
		}
		
		//图形验证码是否为空
		if(empty($req_verify_code)){
			$json->message = '图形验证码不能为空！';
			return Json::encode($json);
		}

		//图形验证码是否正确
		$verify_code  = $session->get(MerchantConst::CAPTCHA_ACTION_KEY);
// 		Yii::info('$verify_code:'.$_SESSION[MerchantConst::CAPTCHA_ACTION_KEY]);
		
		if(isset($req_verify_code) && strcmp($verify_code, $req_verify_code)!=0){
			$json->message = '图形验证码不正确！';
			return Json::encode($json);
		}		
		
		//根据数据库判断验证码获取时间间隔，每天只能获取5次验证码，每隔60秒获取一次
		$last_verify = SysVerifyCode::find()->where('expiration_time>= :expiration_time AND verify_type = :verify_type AND verify_number =:verify_number',
				['expiration_time'=>date (MerchantConst::DATE_FORMAT, time ()),
				'verify_type'=>SysParameter::param_verify_mobile,
				'verify_number' => $vip_id,
				])->orderBy('sent_time DESC')->one();
		if($last_verify){
			$diff_seconds = time() - strtotime($last_verify->sent_time);
			if($diff_seconds <= 1*60){
				$json->message = '您获取验证码时间过于频繁，请稍后再试！';
				return Json::encode($json);
			}
		}
		
		$start_time = date('Y-m-d 0:0:0',time());
		$end_time = date('Y-m-d 23:59:59',time());
		$count = SysVerifyCode::findBySql("SELECT COUNT(1) FROM t_sys_verify_code WHERE sent_time >= :start_time AND sent_time <= :end_time AND verify_type = :verify_type AND verify_number =:verify_number ",
				['start_time'=>$start_time,'end_time'=>$end_time,'verify_type'=>SysParameter::param_verify_mobile,'verify_number' => $vip_id,])->scalar();
// 		$count = SysVerifyCode::find()->select("COUNT(1)")->where('sent_time >= :start_time AND sent_time <= :end_time AND verify_type = :verify_type AND verify_number =:verify_number',
// 				['start_time'=>$start_time,'end_time'=>$end_time,'verify_type'=>SysParameter::param_verify_mobile,'verify_number' => $vip_id,])->scalar();
		if($count>=4){
			$json->message = '您获取验证码次数过多，请明天再试！';
			return Json::encode($json);
		}
		
		//获取远程api信息
// 		curl_init();
		$sms_code = '666666';	
		$content = "您的验证码为".$sms_code.'，请注意查收。';
		
		
		//将验证码信息写入数据库，
		$sysVerifyCode = new SysVerifyCode(); 
		$sysVerifyCode->verify_type = SysParameter::param_verify_mobile ;
		$sysVerifyCode->sent_time = date ( MerchantConst::DATE_FORMAT, time () );
		$sysVerifyCode->expiration_time = date ( MerchantConst::DATE_FORMAT, time() + 5*60);//验证码有效时间5分钟
		$sysVerifyCode->verify_code = $sms_code;
		$sysVerifyCode->content = $content;
		$sysVerifyCode->verify_number = $vip_id;
// 		$sysVerifyCode->usage_type
		$sysVerifyCode->insert();
		
		
		
		//以json格式返回验证码以及提示信息
		$json->status = true;
		$json->message = '验证码已经发送，请注意查收！';
		return Json::encode($json);
		
		// 		$this->layout = false;
// 		$list = SysParameter::find()->all();
// 		return json_encode(ArrayHelper::map($list,"id", "param_val"));
// 		return Json::encode(ArrayHelper::map($list,"id", "param_val"));
// 		return $this->render('index');
// 		return "index";
	}
	
	
	/* public function actionGetSmsCode() {
		
	} */
}