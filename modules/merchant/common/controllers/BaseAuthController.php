<?php
namespace app\modules\merchant\common\controllers;

use Yii;
use yii\web\Controller;
use app\modules\merchant\common\filters\MerchantAuthBehavior;

class BaseAuthController extends BaseController
{
	/* 公用action */
	/* public function actions()
	{
		return [
				'error' => [
						'class' => 'yii\web\ErrorAction',
				],
				'captcha' => [
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
				],
		];
	} */
	
	public function behaviors()
	{
		return array_merge(parent::behaviors(),[
				'authBehavior' => [
					'class' => MerchantAuthBehavior::className(),
				],
		]);
	}
	
	
	public function beforeAction($action) {
// 		Yii::info("BaseAuthController beforeAction ". Yii::$app->request->absoluteUrl );
		return parent::beforeAction($action);
	}
	
	public function afterAction($action, $result){
// 		Yii::info("BaseAuthController afterAction");
		return parent::afterAction($action, $result);
	}
	
	public function actionError()
	{
		$exception = Yii::$app->errorHandler->exception;
		if ($exception instanceof \yii\base\UserException) {
			$message = $exception->getMessage();
		} else {
			$message = Yii::t('yii', 'An internal server error occurred.');
		}
		if ($exception !== null) {
			return $this->render('error', ['exception' => $exception,'message' => $message,]);
		}
	}
	
}