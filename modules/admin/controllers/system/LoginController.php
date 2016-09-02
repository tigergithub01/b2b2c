<?php

namespace app\modules\admin\controllers\system;

use Yii;
use yii\web\Controller;
use app\models\b2b2c\SysUser;
use app\modules\admin\common\controllers\BaseController;

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
		$model = new SysUser();
		if ($model->load(Yii::$app->request->post()) && $model->validate()/*  && $this->login($model) */) {
			Yii::$app->response->redirect("/admin/default/index");
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
	 * 登陆
	 * @param unknown $model
	 */
	private function login($model){
		//判断用户名是否存在
		
		//判断密码是否正确
		
		//判断验证码是否正确
		
// 		$model->addError("password","密码不正确");

		return false;
	}
	
	
	public function actionRegister(){
		return $this->render("register");
	}
	
	
	public function actionForgetPassword(){
		return $this->render("forget-Password"); 
	}
}