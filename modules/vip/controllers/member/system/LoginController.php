<?php

namespace app\modules\vip\controllers\member\system;

use Yii;
use yii\web\Controller;
use app\models\b2b2c\Vip;
use yii\helpers\Url;
use app\modules\vip\common\controllers\BaseController;
use app\modules\vip\service\vip\VipService;
use app\modules\vip\models\VipConst;

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
		$service = new VipService();
		
		/* 初始化插入一个系统管理员  */
		$test_Vip = new Vip();
// 		$system_user->insertSystemUser();
		
		/* 登陆 */
		$model = new Vip();
		$model->setScenario(Vip::SCENARIO_LOGIN);
		
		$vip_db = null;
		if ($model->load(Yii::$app->request->post()) && ($vip_db = $service->login($model)) /* && $model->validate() */ /* && ($user_db = $model->login()) */) {
			/* $valid = $model->validate(); */
// 			$model->password = md5($model->password);
			if($vip_db){
				//写session
				$session = Yii::$app->session;
				$session->set(VipConst::LOGIN_VIP_USER,$vip_db);
				
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
							'value' => $vip_db->vip_id,
							'expire'=>time()+3600*24*7
					]));
					$cookies->add(new \yii\web\Cookie([
							'name' => VipConst::COOKIE_VIP_PASSWORD,
							'value' => $vip_db->password,
							'expire'=>time()+3600*24*7
					]));
				}else{
					/* unset($_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID]);
					 unset($_COOKIE[AdminConst::COOKIE_ADMIN_PASSWORD]); */
					$cookies = Yii::$app->response->cookies;
					$cookies->remove(VipConst::COOKIE_VIP_USER_ID);
					$cookies->remove(VipConst::COOKIE_VIP_PASSWORD);
				}
				
				//登陆成功后根据情况进行跳转
				$last_access_url = Yii::$app->session->get(VipConst::VIP_LAST_ACCESS_URL);
				if($last_access_url){
					Yii::$app->session->remove(VipConst::VIP_LAST_ACCESS_URL);
					Yii::$app->response->redirect($last_access_url);
				}else{
					Yii::$app->response->redirect("/vip/member/default/index");
				}
			}
// 			return $this->goBack();
		}
		/* return $this->renderPartial('index', [
				'model' => $model,
		]); */
		
		/* return $this->renderContent('index', [
				'model' => $model,
		]); */
		
		
		/* return $this->renderAjax('index', [
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
	
	/* 找回密码  */
	public function actionForgotPwd(){
		$service = new VipService();
		
		/* 登陆 */
		$model = new Vip();
		$model->setScenario(Vip::SCENARIO_FORGOT_PWD);
		
		$vip_db = null;
		if ($model->load(Yii::$app->request->post()) && ($vip_db = $service->forgot_pwd($model)) /* && $model->validate() */ /* && ($user_db = $model->login()) */) {
			/* $valid = $model->validate(); */
// 			$model->password = md5($model->password);
			/* if(($vip_db = $merchantService->login($model))){ */
			if($vip_db){
				//找回密码成功后，跳转到登陆页面
				Yii::$app->response->redirect(Url::toRoute(['/vip/member/system/login/index']));
			}
			// 			return $this->goBack();
		}
		/* return $this->renderPartial('index', [
		 'model' => $model,
		]); */
		
		/* return $this->renderContent('index', [
		 'model' => $model,
		]); */
		
		
		/* return $this->renderAjax('index', [
		 'model' => $model,
		]); */
		
		
		return $this->render('forgot-pwd', [
				'model' => $model,
		]);		 
	}
}