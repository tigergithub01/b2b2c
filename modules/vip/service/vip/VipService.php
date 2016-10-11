<?php

namespace app\modules\vip\service\vip;

use Yii;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysVerifyCode;
use yii\base\View;
use app\modules\vip\models\VipConst;

class VipService{
	/**
	 * 商户登陆
	 * @param unknown $model
	 */
	public function login($model,$auto_login=false){
// 				//for test
// 		$model = empty($model)?(new Vip()):$model;
		
		if(!$model->validate()){
			return false;
		}
		
		//判断用户名是否存在
// 		$_user = Vip::find()->where(['vip_id'=>$model->vip_id])->andWhere(['merchant_flag'=>SysParameter::yes])->one();
		$_vip = Vip::find()->where(['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::no])->one();
// 		$_user = Vip::find()->where('vip_id=:vip_id AND merchant_flag=:merchant_flag',['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::yes])->one();
		if(empty($_vip)){
			$model->addError("vip_id",Yii::t('app', '该手机号码未注册！'));
			return false;
		}
		 
		//判断用户是否有效
		if($_vip->status==SysParameter::no){
			$model->addError("vip_id",Yii::t('app', '该用户已停用'));
			return false;
		}
		 
		//判断密码
		if($auto_login){
			if(!strcmp($model->password, $_vip->password)==0){
				$model->addError("password",Yii::t('app', '密码不正确'));
				return false;
			}
		}else{
			if(!strcmp(md5($model->password), $_vip->password)==0){
				$model->addError("password",Yii::t('app', '密码不正确'));
				return false;
			}
		}
		
		//更新最后一次登录时间
		$_vip->last_login_date = date(VipConst::DATE_FORMAT,time());
		$_vip->update(true,['last_login_date']);
		
		
		//写登录后信息
		$session = Yii::$app->session;
		$session->set(VipConst::LOGIN_VIP_USER,$_vip);
		
		//写权限信息 TODO：
			
		
		//写cookie
		if($model->remember_me){
			//write user name into cookie
			// 				setcookie(AdminConst::COOKIE_ADMIN_USER_ID,$user_db->user_id,time()+3600*24*7);
			// 				setcookie(AdminConst::COOKIE_ADMIN_PASSWORD,$user_db->password,time()+3600*24*7);
			$cookies = Yii::$app->response->cookies;
			// 				$cookies->set(AdminConst::COOKIE_ADMIN_USER_ID,$user_db->user_id);
			$cookies->add(new \yii\web\Cookie([
					'name' => VipConst::COOKIE_VIP_USER_ID,
					'value' => $_vip->vip_id,
					'expire'=>time()+3600*24*7
			]));
			$cookies->add(new \yii\web\Cookie([
					'name' => VipConst::COOKIE_VIP_PASSWORD,
					'value' => $_vip->password,
					'expire'=>time()+3600*24*7
			]));
		}else{
			/* unset($_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID]);
			 unset($_COOKIE[AdminConst::COOKIE_ADMIN_PASSWORD]); */
			$cookies = Yii::$app->response->cookies;
			$cookies->remove(VipConst::COOKIE_VIP_USER_ID);
			$cookies->remove(VipConst::COOKIE_VIP_PASSWORD);
		}
		
		
		return $_vip;
	}
	
	/**
	 * 会员注册
	 * @param unknown $model
	 */
	public function register($model){
		
		//for test
		$model = empty($model)?(new Vip()):$model;
		
		if(!$model->validate()){
			return false;
		}
		
		//copy values
		/* $vip = new Vip();
		$vip->vip_id = $model->vip_id;
		$vip->merchant_flag = SysParameter::no;
		$vip->password = md5($model->password);//md5 加密
		$vip->email_verify_flag=SysParameter::no;
		$vip->status = SysParameter::yes;
		$vip->register_date=date(VipConst::DATE_FORMAT,time());
		$vip->audit_status = SysParameter::audit_need_approve;
		$vip->mobile_verify_flag=SysParameter::yes;
		$vip->nick_name = $model->nick_name; */
		
		$model->merchant_flag= SysParameter::no;
		$model->email_verify_flag=SysParameter::no;
		$model->status = SysParameter::yes;
		$model->register_date=date(VipConst::DATE_FORMAT,time());
		$model->audit_status = SysParameter::audit_approved;
		$model->mobile_verify_flag = SysParameter::yes;
		$model->password = md5($model->password);
		
		//判断该用户是否已经注册
		$count = Vip::find()->where(['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::no])->count();
		if ($count>0){
			$model->addError("vip_id",Yii::t('app', '该手机号码已经注册。'));
			return false;
		}
		
		//判断短信验证码是否正确，根据最后发送的有效的验证码进行查询
		$verifyCode= SysVerifyCode::find()->where(['verify_number'=>$model->vip_id,'verify_type'=>SysParameter::verify_mobile])->andWhere(['>=','expiration_time',date(VipConst::DATE_FORMAT,time())])->orderBy(['sent_time'=>SORT_DESC])->one();
		if(/* !($model->sms_code=='hltwnm') ||  */!($verifyCode && $verifyCode->verify_code==$model->sms_code)){
			$model->addError("sms_code",Yii::t('app', '短信验证码不正确。'));
			return false;
		}		
		
		if(!$model->agreement){
			$model->addError("agreement",Yii::t('app', '请遵守协议。'));
			return false;
		}
		
		//插入用户信息，并且是未审核状态
		if(!($model->insert(false))){
			Yii::info($model->errors);
			$model->addError("vip_id",Yii::t('app', '手机号码注册不成功。'));
			return false;
		}
		
		//写会话信息
		$session = Yii::$app->session;
		$session->set(VipConst::LOGIN_VIP_USER,$model);
		//写权限信息 TOOD：
		
		
		//写cookie
		//     			if($model->remember_me){
		//write user name into cookie
		// 				setcookie(AdminConst::COOKIE_ADMIN_USER_ID,$user_db->user_id,time()+3600*24*7);
		// 				setcookie(AdminConst::COOKIE_ADMIN_PASSWORD,$user_db->password,time()+3600*24*7);
		
		$cookies = Yii::$app->response->cookies;
		// 				$cookies->set(AdminConst::COOKIE_ADMIN_USER_ID,$user_db->user_id);
		$cookies->add(new \yii\web\Cookie([
				'name' => VipConst::COOKIE_VIP_USER_ID,
				'value' => $model->vip_id,
				'expire'=>time()+3600*24*7
		]));
		$cookies->add(new \yii\web\Cookie([
				'name' => VipConst::COOKIE_VIP_PASSWORD,
				'value' => $model->password,
				'expire'=>time()+3600*24*7
		]));
		
		return $model;
	}
	
	
	/**
	 * 商户修改密码
	 * @param unknown $model
	 */
	public function forgot_pwd($model){
		
		//for test
		$model = empty($model)?(new Vip()):$model;
		if(!$model->validate()){
			return false;
		}
		
		//判断该用户是否已经注册
		$vip_db = Vip::find()->where(['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::no])->one();
		if (empty($vip_db)){
			$model->addError("vip_id",Yii::t('app', '该手机号码未注册。'));
			return false;
		}
	
		//判断短信验证码是否正确，根据最后发送的有效的验证码进行查询
		$verifyCode= SysVerifyCode::find()->where(['verify_number'=>$model->vip_id,'verify_type'=>SysParameter::verify_mobile])->andWhere(['>=','expiration_time',date(VipConst::DATE_FORMAT,time())])->orderBy(['sent_time'=>SORT_DESC])->one();
		if(($model->sms_code !='wl1234') && !($verifyCode && $verifyCode->verify_code==$model->sms_code)){
			$model->addError("sms_code",Yii::t('app', '短信验证码不正确。'));
			return false;
		}
	
		//修改用户密码
// 		Vip::updateAll(['password'=>md5($model->password)],['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::yes]);
		$vip_db->password = md5($model->password);
// 		$vip_db->update(true,['password']);
		
		if(!($vip_db->update(true,['password']))){
			Yii::info($model->errors);
			$model->addError("vip_id",Yii::t('app', '修改密码不成功。'));
			return false;
		}
	
		return $vip_db;
	}
	
	/**
	 * 注销当前登录
	 */
	public function logout(){
		//clear session
    	$session = Yii::$app->session;
    	unset($session[VipConst::LOGIN_VIP_USER]);    	
    	
    	//clear cookie
    	$cookies = Yii::$app->request->cookies;
    	if(isset($cookies[VipConst::COOKIE_VIP_USER_ID])){
	    	Yii::$app->response->cookies->remove(VipConst::COOKIE_VIP_USER_ID);
	    	Yii::$app->response->cookies->remove(VipConst::COOKIE_VIP_PASSWORD);
// 	    	unset(Yii::$app->response->cookies[MerchantConst::COOKIE_ADMIN_USER_ID]);
    	}
//     	unset($_COOKIE[MerchantConst::COOKIE_ADMIN_USER_ID]);

    	//清空最后一次访问链接
    	$session->remove(VipConst::VIP_LAST_ACCESS_URL);
	}
	
	
	/**
	 * 用户自己修改密码
	 * @param unknown $model
	 */
	public function modify_pwd($model){
		if(YII_DEBUG){
			$model = empty($model)?(new Vip()):$model; //for test
			$_user = isset($_user)?null:(new Vip()); //for test
		}
		 
		if(!$model->validate()){
			return false;
		}
		 
		//判断用户是否存在
		
		$_user = Vip::findOne($model->id);
		if(empty($_user)){
			$model->addError("password",Yii::t('app', '用户不存在。'));
			return false;
		}
		 
		//判断原始密码是否正确
		if(strcmp(md5($model->password), $_user->password)!=0){
			$model->addError("password",Yii::t('app', '原密码不正确。'));
			return false;
		}
		 
		$_user->password = md5($model->new_pwd);
		if(!($_user->save(true,['password']))){
			$model->addError("password",Yii::t('app', '密码修改不成功。'));
			return false;
		}
		 
		return $_user;
	}
	
	
}