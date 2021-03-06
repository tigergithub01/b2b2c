<?php
namespace app\modules\vip\common\controllers;

use app\modules\vip\common\filters\VipAuthFilter;


/**
 * 会员中心
 * @author Tiger-guo
 *
 */
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
	
	public $layout="main";
	
	public function behaviors()
	{
		return array_merge(parent::behaviors(),[VipAuthFilter::className(),
				/* 'authBehavior' => [
					'class' => VipAuthBehavior::className(),
				], */
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
	
	/* public function actionError()
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
	} */
	
}