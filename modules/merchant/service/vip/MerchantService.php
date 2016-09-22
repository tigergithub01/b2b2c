<?php

namespace app\modules\merchant\service\vip;

use Yii;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;
use app\modules\merchant\models\MerchantConst;
use app\models\b2b2c\SysVerifyCode;
use yii\base\View;


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
		if(!($vip->insert())){
			Yii::info($model->errors);
			$model->addError("vip_id",Yii::t('app', '手机号码注册不成功。'));
			return false;
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
	
	
}