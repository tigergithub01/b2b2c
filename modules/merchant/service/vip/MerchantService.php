<?php

namespace app\modules\merchant\service\vip;

use Yii;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;
use app\modules\merchant\models\MerchantConst;


class MerchantService{
	/**
	 * 商户登陆
	 * @param unknown $model
	 */
	public function login($model){
// 				$model=new Vip();//for test
		//判断用户名是否存在
// 		$_user = Vip::find()->where(['vip_id'=>$model->vip_id])->andWhere(['merchant_flag'=>SysParameter::param_yes])->one();
		$_vip = Vip::find()->where(['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::param_yes])->one();
// 		$_user = Vip::find()->where('vip_id=:vip_id AND merchant_flag=:merchant_flag',['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::param_yes])->one();
		if(empty($_vip)){
			$model->addError("vip_id",Yii::t('app', '该手机号码未注册！'));
			return false;
		}
		 
		//判断用户是否有效
		if($_vip->status==SysParameter::param_no){
			$model->addError("vip_id",Yii::t('app', '该用户已停用'));
			return false;
		}
		 
		//判断密码
		if(!strcmp($model->password, $_vip->password)==0){
			$model->addError("password",Yii::t('app', '密码不正确'));
			return false;
		}
		
		//更新最后一次登录时间
		$model->last_login_date = date(MerchantConst::DATE_FORMAT,time());
		$model->update(true,['last_login_date']);
		
		return $model;
	}
	
	/**
	 * 商户注册
	 * @param unknown $model
	 */
	public function register($model){
		
		return $model;
	}
	
	
}