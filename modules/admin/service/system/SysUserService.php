<?php

namespace app\modules\admin\service\system;

use Yii;
use app\models\b2b2c\SysUser;
use app\modules\admin\models\AdminConst;
use app\models\b2b2c\SysParameter;



class SysUserService{
	
	/**
	 * 登陆
	 * @return boolean|unknown
	 */
	public function login($model){
		
// 		$model=new SysUser();//for test
    	//判断用户名是否存在
		
    	$_user = SysUser::find()->where(['user_id'=>$model->user_id])->one();
    	if(empty($_user)){
    		$model->addError("user_id",Yii::t('app', '用户名不存在'));
    		return false;
    	}
    	
    	//判断用户是否有效
    	if($_user->status==SysParameter::param_no){
    		$model->addError("user_id",Yii::t('app', '用户未激活'));
    		return false;
    	}
    	
    	//判断密码
    	if(!strcmp($model->password, $_user->password)==0){
    		$model->addError("password",Yii::t('app', '密码不正确'));
    		return false;
    	}
    	 
    	//更新最后一次登录时间
    	$model->last_login_date = date(AdminConst::DATE_FORMAT,time());
    	$model->update(true,['last_login_date']);
    	 
    	return $model;
    }
    
    /**
     * 初始化插入一个系统管理员
     */
    public function insertSystemUser(){
    	//     	$model = new SysUser();
    	// 		'user_id', 'password', 'is_admin', 'status'
    	$_usr = SysUser::find()->where('user_id=:p_user_id',['p_user_id'=>'admin'])->one();
    	if(empty($_usr)){
    		$model=new SysUser();
    		$model->user_id='admin';
    		$model->password=md5("admin123");
    		$model->is_admin =1;
    		$model->status = 1;
    		$model->validate();
    		$success = $model->save();
    		Yii::info("insertSystemUsr $success");
    	}
    }
	
	
	
	
}