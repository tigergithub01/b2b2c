<?php

namespace app\modules\vip\controllers\member\system;

use Yii;
use yii\filters\AccessControl;
use app\modules\vip\common\controllers\BaseController;
use app\modules\vip\models\VipConst;
use yii\helpers\Json;
use app\models\b2b2c\SysParameter;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\common\JsonObj;
use app\models\b2b2c\SysVerifyCode;
use app\common\utils\sms\SmsUtils;
use app\common\utils\CommonUtils;

/**
 * 获取短信验证码
 * http://localhost:8089/vip/member/system/sms/index?vip_id=13724346643&img_verify=0
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
		$img_verify =  $request->post('img_verify');//是否需要图形验证码
		$img_verify = (($img_verify==0)?false : true); //默认需要验证图形码
		
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
		
		/* 需要图形验证码 */
		if($img_verify){
			//图形验证码是否为空
			if(empty($req_verify_code)){
				$json->message = '图形验证码不能为空！';
				return Json::encode($json);
			}
	
			//图形验证码是否正确
			$verify_code  = $session->get(VipConst::CAPTCHA_ACTION_KEY);
	// 		Yii::info('$verify_code:'.$_SESSION[MerchantConst::CAPTCHA_ACTION_KEY]);
			
			if(isset($req_verify_code) && strcmp($verify_code, $req_verify_code)!=0){
				$json->message = '图形验证码不正确！';
				return Json::encode($json);
			}		
		}
		
		//根据数据库判断验证码获取时间间隔，每天只能获取5次验证码，每隔60秒获取一次
		$last_verify = SysVerifyCode::find()->where('expiration_time>= :expiration_time AND verify_type = :verify_type AND verify_number =:verify_number',
				['expiration_time'=>date (VipConst::DATE_FORMAT, time ()),
				'verify_type'=>SysParameter::verify_mobile,
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
// 		$count = SysVerifyCode::findBySql("SELECT COUNT(1) FROM t_sys_verify_code WHERE sent_time >= :start_time AND sent_time <= :end_time AND verify_type = :verify_type AND verify_number =:verify_number ",
// 				['start_time'=>$start_time,'end_time'=>$end_time,'verify_type'=>SysParameter::verify_mobile,'verify_number' => $vip_id,])->scalar();
		$count = SysVerifyCode::find()->where('sent_time >= :start_time AND sent_time <= :end_time AND verify_type = :verify_type AND verify_number =:verify_number',
				['start_time'=>$start_time,'end_time'=>$end_time,'verify_type'=>SysParameter::verify_mobile,'verify_number' => $vip_id,])->count();
		if($count>=5){
			$json->message = '您获取验证码次数过多，请明天再试！';
			return Json::encode($json);
		}
		
		//获取远程api信息
		$smsUtils = new SmsUtils();
		$sms_code = $smsUtils->random(6, 1);	
		$resp_arr = $smsUtils->sendSms($vip_id, $sms_code);
		if(!($resp_arr['status'])){
			$json->message = '验证码发送失败。'.$resp_arr['msg'];
			return Json::encode($json);
		}
		
		$content = "您的验证码为" . $sms_code . '，请注意查收。';
		
		//将验证码信息写入数据库，
		$sysVerifyCode = new SysVerifyCode(); 
		$sysVerifyCode->verify_type = SysParameter::verify_mobile ;
		$sysVerifyCode->sent_time = date ( VipConst::DATE_FORMAT, time () );
		$sysVerifyCode->expiration_time = date ( VipConst::DATE_FORMAT, time() + 5*60);//验证码有效时间5分钟
		$sysVerifyCode->verify_code = $sms_code;
		$sysVerifyCode->content = $content;
		$sysVerifyCode->verify_number = $vip_id;
// 		$sysVerifyCode->usage_type
		$sysVerifyCode->insert();
		
		
		
		//以json格式返回验证码以及提示信息
		$json->status = true;
		$json->value = ['verify_code'=>$sms_code];
		$json->message = '验证码已经发送，请注意查收！';
		return Json::encode($json);
		
		// 		$this->layout = false;
// 		$list = SysParameter::find()->all();
// 		return json_encode(ArrayHelper::map($list,"id", "param_val"));
// 		return Json::encode(ArrayHelper::map($list,"id", "param_val"));
// 		return $this->render('index');
// 		return "index";
	}
	
	/* 
	 * 
	 短信验证码验证
	 http://localhost:8089/vip/member/system/sms/verify-sms-code?vip_id=13724346643&sms_code=111111
	 *  */
	public function actionVerifySmsCode(){
		//获取参数
		$vip_id = isset($_REQUEST['vip_id'])?$_REQUEST['vip_id']:null;
		$sms_code = isset($_REQUEST['sms_code'])?$_REQUEST['sms_code']:null;
		
		//定义返回值
		$jsonObj = new JsonObj();
		
		//手机号码是否为空
		if(empty($vip_id)){
			$jsonObj->message = '手机号码不能为空！';
			return CommonUtils::jsonObj_failed($jsonObj);
		}
		
		//短信验证码是否为空
		if(empty($sms_code)){
			$jsonObj->message = '短信验证码不能为空！';
			return CommonUtils::jsonObj_failed($jsonObj);
		}
		
		//判断短信验证码是否正确，根据最后发送的有效的验证码进行查询
		$verifyCode= SysVerifyCode::find()->where(['verify_number'=>$vip_id,'verify_type'=>SysParameter::verify_mobile])->andWhere(['>=','expiration_time',date(VipConst::DATE_FORMAT,time())])->orderBy(['sent_time'=>SORT_DESC])->one();
		if(/* !($model->sms_code=='hltwnm') ||  */!($verifyCode && $verifyCode->verify_code==$sms_code)){
			$jsonObj->message = '短信验证码不正确！';
			return CommonUtils::jsonObj_failed($jsonObj);
		}
		
		return CommonUtils::jsonObj_success($jsonObj);
	}
	
	
	/* public function actionGetSmsCode() {
		
	} */
}
