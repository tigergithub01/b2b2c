<?php

namespace app\modules\admin\controllers\system;

use Yii;
use yii\web\Controller;
use app\models\b2b2c\SysUser;
use app\modules\admin\common\controllers\BaseController;
use app\modules\admin\models\AdminConst;

/**
 * login controller
 * @author Tiger-guo
 *
 */
class LoginController extends BaseController
{
	
	
	public $layout = "main-login";
	
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex()
	{
		/* 初始化插入一个系统管理员  */
		$system_user = new SysUser();
		$system_user->insertSystemUser();		
		
		/* 登陆 */
		$model = new SysUser();
		$model->setScenario(SysUser::SCENARIO_LOGIN);
		
		$user_db = null;
		if ($model->load(Yii::$app->request->post()) && $model->validate() /* && ($user_db = $model->login()) */) {
			/* $valid = $model->validate(); */
			$model->password = md5($model->password);
			if(($user_db = $model->login())){
				//写session
				$session = Yii::$app->session;
				$session->set(AdminConst::LOGIN_ADMIN_USER,$user_db);
				//写权限信息 TOOD：
					
				//写cookie
				if($model->remember_me){
					//write user name into cookie
					// 				setcookie(AdminConst::COOKIE_ADMIN_USER_ID,$user_db->user_id,time()+3600*24*7);
					// 				setcookie(AdminConst::COOKIE_ADMIN_PASSWORD,$user_db->password,time()+3600*24*7);
				
					$cookies = Yii::$app->response->cookies;
					// 				$cookies->set(AdminConst::COOKIE_ADMIN_USER_ID,$user_db->user_id);
					$cookies->add(new \yii\web\Cookie([
							'name' => AdminConst::COOKIE_ADMIN_USER_ID,
							'value' => $user_db->user_id,
							'expire'=>time()+3600*24*7
					]));
					$cookies->add(new \yii\web\Cookie([
							'name' => AdminConst::COOKIE_ADMIN_PASSWORD,
							'value' => $user_db->password,
							'expire'=>time()+3600*24*7
					]));
				}
			}else{
				/* unset($_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID]);
				unset($_COOKIE[AdminConst::COOKIE_ADMIN_PASSWORD]); */
				
				$cookies = Yii::$app->response->cookies;
				$cookies->remove(AdminConst::COOKIE_ADMIN_USER_ID);
				$cookies->remove(AdminConst::COOKIE_ADMIN_PASSWORD);
			}
			
// 			if($valid){

			//根据情况进行跳转
			$last_access_url = Yii::$app->session->get(AdminConst::ADMIN_LAST_ACCESS_URL);
			if($last_access_url){
				Yii::$app->session->remove(AdminConst::ADMIN_LAST_ACCESS_URL);
				Yii::$app->response->redirect($last_access_url);
			}else{
				Yii::$app->response->redirect("/admin/default/index");
			}
			
			
				
// 			}
// 			return $this->goBack();
		}
		/* return $this->renderPartial('login', [
				'model' => $model,
		]); */
		
		
		/* return $this->renderAjax('login', [
				'model' => $model,
		]); */
		
		
		return $this->render('index', [
			'model' => $model,
		]);
		
	}
	
	/**
	 * 初始化插入系统管理员
	 */
	private function insertSystemUser(){
		$model = new SysUser();
		$_usr = SysUser::find()->where('user_id=:p_user_id',['p_user_id'=>'admin'])->one();
		if(empty($_usr)){
			$model->user_id='admin';
			$model->password=md5("admin123");
			$model->is_admin =1;
			$model->status = 1;
			$model->validate();
			$success = $model->save();
			Yii::info("insertSystemUsr $success");
		}
	}
	
	
	
	public function actionRegister(){
		return $this->render("register");
	}
	
	
	public function actionForgetPassword(){
		return $this->render("forget-Password"); 
	}
}