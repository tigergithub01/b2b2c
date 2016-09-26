<?php

namespace app\modules\merchant\service\vip;

use Yii;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;
use app\modules\merchant\models\MerchantConst;
use app\models\b2b2c\SysVerifyCode;
use yii\base\View;
use app\models\b2b2c\VipOrganization;
use app\models\b2b2c\VipExtend;

class MerchantService{
	/**
	 * 商户登陆
	 * @param unknown $model
	 */
	public function login($model,$auto_login=false){
// 				//for test
		$model = empty($model)?(new Vip()):$model;
		
		if(!$model->validate()){
			return false;
		}
		
		//判断用户名是否存在
// 		$_user = Vip::find()->where(['vip_id'=>$model->vip_id])->andWhere(['merchant_flag'=>SysParameter::yes])->one();
		$_vip = Vip::find()->where(['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::yes])->one();
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
		$_vip->last_login_date = date(MerchantConst::DATE_FORMAT,time());
		$_vip->update(true,['last_login_date']);
		
		return $_vip;
	}
	
	/**
	 * 商户注册
	 * @param unknown $model
	 */
	public function register($model){
		
		//for test
		$model = empty($model)?(new Vip()):$model;
		
		//copy values
		$vip = new Vip();
		$vip->vip_id = $model->vip_id;
		$vip->merchant_flag = SysParameter::yes;
		$vip->password = md5($model->password);//md5 加密
		$vip->email_verify_flag=SysParameter::no;
		$vip->status = SysParameter::yes;
		$vip->register_date=date(MerchantConst::DATE_FORMAT,time());
		$vip->audit_status = SysParameter::audit_need_approve;
		$vip->mobile_verify_flag=SysParameter::yes;
		$vip->role_type = $model->role_type;
		
		//判断该用户是否已经注册
		$count = Vip::find()->where(['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::yes])->count();
		if ($count>0){
			$model->addError("vip_id",Yii::t('app', '该手机号码已经注册。'));
			return false;
		}
		
		//判断短信验证码是否正确，根据最后发送的有效的验证码进行查询
		$verifyCode= SysVerifyCode::find()->where(['verify_number'=>$model->vip_id,'verify_type'=>SysParameter::verify_mobile])->andWhere(['>=','expiration_time',date(MerchantConst::DATE_FORMAT,time())])->orderBy(['sent_time'=>SORT_DESC])->one();
		if(!($verifyCode && $verifyCode->verify_code==$model->sms_code)){
			$model->addError("sms_code",Yii::t('app', '短信验证码不正确。'));
			return false;
		}		
		
		if(!$model->agreement){
			$model->addError("agreement",Yii::t('app', '请遵守协议。'));
			return false;
		}
		
		//插入用户信息，并且是未审核状态
		$transaction = Vip::getDb()->beginTransaction();
		try {
			if(!($vip->insert())){
				Yii::info($model->errors);
				$model->addError("vip_id",Yii::t('app', '手机号码注册不成功。'));
				$transaction->rollBack();
				return false;
			}
			
			//insert VipOrganization,插入店铺信息，（因为没有店铺的概念，但是为了保证扩展性，所有默认插入一个店铺）
			$vipOrg =  new VipOrganization();
			$vipOrg->status=SysParameter::yes;
			$vipOrg->vip_id = $vip->id;
			$vipOrg->audit_status = SysParameter::audit_need_approve;
			$vipOrg->create_date = date(MerchantConst::DATE_FORMAT,time());
			$vipOrg->update_date = date(MerchantConst::DATE_FORMAT,time());
			
			if(!($vipOrg->insert())){
				$model->addError("vip_id",Yii::t('app', '手机号码注册不成功。'));
				$transaction->rollBack();
				return false;
			}
			
			//insert VipOrganization extend，插入扩展信息
			$vipExtend = new VipExtend();
			$vipExtend->audit_status  = SysParameter::audit_need_approve;
			$vipExtend->vip_id = $vip->id;
			$vipExtend->create_date = date(MerchantConst::DATE_FORMAT,time());
			$vipExtend->update_date = date(MerchantConst::DATE_FORMAT,time());
			if(!($vipExtend->insert())){
				$model->addError("vip_id",Yii::t('app', '手机号码注册不成功。'));
				$transaction->rollBack();
				return false;
			}			
		} catch (\Exception $e) {
			$transaction->rollBack();
            throw $e;
		}
		return $vip;
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
		$vip_db = Vip::find()->where(['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::yes])->one();
		if (empty($vip_db)){
			$model->addError("vip_id",Yii::t('app', '该手机号码未注册。'));
			return false;
		}
	
		//判断短信验证码是否正确，根据最后发送的有效的验证码进行查询
		$verifyCode= SysVerifyCode::find()->where(['verify_number'=>$model->vip_id,'verify_type'=>SysParameter::verify_mobile])->andWhere(['>=','expiration_time',date(MerchantConst::DATE_FORMAT,time())])->orderBy(['sent_time'=>SORT_DESC])->one();
		if(!($verifyCode && $verifyCode->verify_code==$model->sms_code)){
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
    	unset($session[MerchantConst::LOGIN_MERCHANT_USER]);    	
    	
    	//clear cookie
    	$cookies = Yii::$app->request->cookies;
    	if(isset($cookies[MerchantConst::COOKIE_MERCHANT_USER_ID])){
	    	Yii::$app->response->cookies->remove(MerchantConst::COOKIE_MERCHANT_USER_ID);
	    	Yii::$app->response->cookies->remove(MerchantConst::COOKIE_MERCHANT_PASSWORD);
// 	    	unset(Yii::$app->response->cookies[MerchantConst::COOKIE_ADMIN_USER_ID]);
    	}
//     	unset($_COOKIE[MerchantConst::COOKIE_ADMIN_USER_ID]);

    	//清空最后一次访问链接
    	$session->remove(MerchantConst::MERCHANT_LAST_ACCESS_URL);
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
			$model->addError("password",Yii::t('app', '密码不正确。'));
			return false;
		}
		 
		$_user->password = md5($model->new_pwd);
		if(!($_user->update(true,['password']))){
			$model->addError("password",Yii::t('app', '密码修改不成功。'));
			return false;
		}
		 
		return $_user;
	}
	
	
	/**
	 * 插入店铺信息，商户注册成功后默认增加一个店铺（属于特殊处理，正常情况下应该是先有店铺信息然后才有商品信息）
	 * @param unknown $vip_id
	 */
	function initVipOrg($vip_id){	

		//insert VipOrganization
		$vipOrg =  new VipOrganization();
		$vipOrg->status=SysParameter::yes;
		$vipOrg->vip_id = $vip_id;
		$vipOrg->audit_status = SysParameter::audit_need_approve;
		$vipOrg->insert();
		
		//insert VipOrganization extend
		$vipExtend = new VipExtend();
		$vipExtend->audit_status  = SysParameter::audit_need_approve;
		$vipExtend->vip_id = $vip_id;
		$vipExtend->insert();
		
	}
	
	
}