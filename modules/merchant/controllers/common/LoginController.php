<?php

namespace app\modules\merchant\controllers\common;

use Yii;
use yii\web\Controller;
use app\modules\merchant\models\LoginForm;
use app\modules\merchant\common\controllers\BaseController;

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
			Yii::$app->response->redirect("/merchant/default/index");
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
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			Yii::$app->response->redirect("/merchant/default/index");
			// 			return $this->goBack();
		}
		/* return $this->renderPartial('login', [
		 'model' => $model,
		]); */
		
		
		/* return $this->renderAjax('login', [
		 'model' => $model,
		]); */
		
		return $this->render("register",[
				'model' => $model,
		]);
	}
	
	
	public function actionForgetPassword(){
		return $this->render("forget-Password"); 
	}
	
	
	
	
}