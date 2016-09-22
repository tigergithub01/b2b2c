<?php

namespace app\modules\admin\service\system;

use Yii;
use app\models\b2b2c\SysUser;
use app\modules\admin\models\AdminConst;
use app\models\b2b2c\SysParameter;
use app\modules\merchant\models\MerchantConst;


class SysUserService{
	
	/**
	 * 登陆
	 * @return boolean|unknown
	 */
	public function login($model,$auto_login=false){
		$model = empty($model)?(new SysUser()):$model; //for test
		if(!$model->validate()){
			return false;
		}
		
		//判断用户名是否存在
    	$_user = SysUser::find()->where(['user_id'=>$model->user_id])->one();
    	if(empty($_user)){
    		$model->addError("user_id",Yii::t('app', '用户名不存在'));
    		return false;
    	}
    	
    	//判断用户是否有效
    	if($_user->status==SysParameter::no){
    		$model->addError("user_id",Yii::t('app', '用户未激活'));
    		return false;
    	}
    	
    	//判断密码
    	if($auto_login){
    		if(!strcmp($model->password, $_user->password)==0){
    			$model->addError("password",Yii::t('app', '密码不正确'));
    			return false;
    		}
    	}else{
    		if(!strcmp(md5($model->password), $_user->password)==0){
    			$model->addError("password",Yii::t('app', '密码不正确'));
    			return false;
    		}
    	}
    	 
    	//更新最后一次登录时间
    	$_user->last_login_date = date(AdminConst::DATE_FORMAT,time());
    	$_user->update(true,['last_login_date']);
    	 
    	return $_user;
    }
    
    /**
     * 用户自己修改密码
     * @param unknown $model
     */
    public function modify_pwd($model){
    	if(YII_DEBUG){
    		$model = empty($model)?(new SysUser()):$model; //for test
    	}
    	
    	if(!$model->validate()){
    		return false;
    	}
    	
    	//判断用户是否存在
    	$_user = SysUser::findOne($model->id);
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
	
    /**
     * 注销当前登录
     */
    public function logout(){
    	//clear session
    	$session = Yii::$app->session;
    	unset($session[AdminConst::LOGIN_ADMIN_USER]);    	
    	
    	//clear cookie
    	$cookies = Yii::$app->request->cookies;
    	if(isset($cookies[AdminConst::COOKIE_ADMIN_USER_ID])){
	    	Yii::$app->response->cookies->remove(AdminConst::COOKIE_ADMIN_USER_ID);
	    	Yii::$app->response->cookies->remove(AdminConst::COOKIE_ADMIN_PASSWORD);
// 	    	unset(Yii::$app->response->cookies[AdminConst::COOKIE_ADMIN_USER_ID]);
    	}
//     	unset($_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID]);
		
    	//清空最后一次访问链接
    	$session->remove(AdminConst::ADMIN_LAST_ACCESS_URL);
    }
	
	
}