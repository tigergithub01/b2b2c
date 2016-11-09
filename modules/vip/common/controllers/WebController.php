<?php
namespace app\modules\vip\common\controllers;

use app\models\b2b2c\common\JsonObj;
use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;

class WebController extends Controller
{
	public $layout="main-blank";
	
	
	/* 公用action 
	 注意：ErrorAction的优先级要高于actionError的优先级 */
	
	/* 问题：问什么必须使用/site/captcha,使用指定的captcha如Url::toRoute(['system/login/captcha'])，客户端提示验证码不正确。 */
	public function actions()
	{
		return [
				/* 'error' => [
						'class' => 'yii\web\ErrorAction',
				], */
				'captcha' => [
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
						'minLength' => 4,
						'maxLength' => 4,
				],
		];
	}
	
	public function behaviors()
	{
		return parent::behaviors();
	}
	
	
	public function beforeAction($action) {
// 		Yii::info("BaseController beforeAction ". Yii::$app->request->absoluteUrl );
// 		var_dump($action);
		header("Access-Control-Allow-Origin: *");//允許跨域訪問
		header("Access-Control-Allow-Methods: POST, GET, OPTIONS");//允許跨域訪問
		header("Access-Control-Allow-Headers: X-PINGOTHER");//允許跨域訪問
		return parent::beforeAction($action);
	}
	
	public function afterAction($action, $result){
// 		Yii::info("BaseController afterAction");
		return parent::afterAction($action, $result);
	}
	
	/**
	 * 自定义错误处理
	 * @return Ambigous <string, string>
	 */
	public function actionError()
	{
		$this->layout = 'main-blank';

// 		$this->layout = false;
		
		if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
			// action has been invoked not from error handler, but by direct route, so we display '404 Not Found'
			$exception = new HttpException(404, Yii::t('yii', 'Page not found.'));
		}
		
		if ($exception instanceof HttpException) {
			$code = $exception->statusCode;
		} else {
			$code = $exception->getCode();
		}
		if ($exception instanceof Exception) {
			$name = $exception->getName();
		} else {
			$name = Yii::t('yii', 'Error');
		}
		if ($code) {
			$name .= " (#$code)";
		}
		
		if ($exception instanceof UserException) {
			$message = $exception->getMessage();
		} else {
			$message = Yii::t('yii', 'An internal server error occurred.');
		}
		
		if (Yii::$app->getRequest()->getIsAjax()) {
			$this->layout = false;
			$jsonObj = new JsonObj();
			$jsonObj->status = false;
			$jsonObj->message = "$name: $message";
			return Json::encode($jsonObj);
// 			return "$name: $message";
		} else {
			return $this->render('error', [
					'name' => $name,
					'message' => $message,
					'exception' => $exception,
			]);
		}
	}
	
}