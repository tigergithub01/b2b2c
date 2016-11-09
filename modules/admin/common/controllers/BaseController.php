<?php
namespace app\modules\admin\common\controllers;

use app\models\b2b2c\common\JsonObj;
use app\modules\admin\common\filters\AdminLogFilter;
use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;

class BaseController extends Controller
{
	/* 公用action 
	 注意：ErrorAction的优先级要高于actionError的优先级 */
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
				'upload' => [
						'class' => 'kucha\ueditor\UEditorAction',
						'config' => [
								//"imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
								"imagePathFormat" => "/uploads/ueditor/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
								"imageRoot" => Yii::getAlias("@webroot"),
						],
				]
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
// 		Yii::info("BaseController beforeAction ". Yii::$app->request->absoluteUrl );
// 		var_dump($action);
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
		}else{
			$name = Yii::t('yii', 'Error');
		}
		
		if ($exception instanceof UserException) {
			$message = $exception->getMessage();
		} else {
			$message = Yii::t('yii', 'An internal server error occurred.');
		}
		
		if (Yii::$app->getRequest()->getIsAjax()) {
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
		
		
		/* $exception = Yii::$app->errorHandler->exception;
		if ($exception instanceof \yii\base\UserException) {
			$message = $exception->getMessage();
		} else {
			$message = Yii::t('yii', 'An internal server error occurred.');
		}
		if ($exception !== null) {
			return $this->render('error', ['exception' => $exception,'message' => $message,'name'=>$name]);
			
			//TODO：根据是否为ajax请求输出不同的结果，如果为ajax请求，则需要输出json格式的字符串。
			if(Yii::$app->request->isAjax){
				$jsonObj = new JsonObj();
				$jsonObj->status = false;
				$jsonObj->message = $message;
				return Json::encode($jsonObj);
			}
		} */
	}
	
}