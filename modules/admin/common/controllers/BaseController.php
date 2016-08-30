<?php
namespace app\modules\admin\common\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\admin\common\filters\AdminLogFilter;

class BaseController extends Controller
{
	/* 公用action 
	 注意：ErrorAction的优先级要高于actionError的优先级 */
	public function actions()
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
	}
	
	public function behaviors()
	{
		return [
				/* 'access' => [
						'class' => AccessControl::className(),
// 						'only' => ['logout'],
						'rules' => [
								[
										'actions' => ['logout'],
										'allow' => true,
								],
						],
				], */
				'logFilter' => [
					'class' => AdminLogFilter::className(),
// 						'class' => "app\modules\admin\common\filters\AdminAuthFilter",
				],
		];
	}
	
	
	public function beforeAction($action) {
		Yii::info("BaseController beforeAction ". Yii::$app->request->absoluteUrl );
		return parent::beforeAction($action);
	}
	
	public function afterAction($action, $result){
		Yii::info("BaseController afterAction");
		return parent::afterAction($action, $result);
	}
	
	/**
	 * 自定义错误处理
	 * @return Ambigous <string, string>
	 */
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