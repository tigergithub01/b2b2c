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
		
		/* 登陆 */
		$model = new Vip();
		$model->setScenario(Vip::SCENARIO_LOGIN);
		
		$vip_db = null;
		if ($model->load(Yii::$app->request->post()) && ($vip_db = $service->login($model)) /* && $model->validate() */ /* && ($user_db = $model->login()) */) {
			/* $valid = $model->validate(); */
// 			$model->password = md5($model->password);
			if($vip_db){
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