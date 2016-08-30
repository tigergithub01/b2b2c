<?php

namespace app\modules\admin\controllers\common;

use Yii;
use yii\web\Controller;
use app\modules\admin\models\LoginForm;
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
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			Yii::$app->response->redirect("/admin/default/index");
// 			return $this->goBack();
		}
		/* return $this->renderPartial('login', [
				'model' => $model,
		]); */
		
		
		/* return $this->renderAjax('login', [
				'model' => $model,
		]); */
		
		return $this->render('login', [
				'model' => $model,
		]);
		
	}
	
	
	public function actionRegister(){
		return $this->render("register");
	}
	
	
	public function actionForgetPassword(){
		return $this->render("forget-Password"); 
	}
	
	
	
	
}