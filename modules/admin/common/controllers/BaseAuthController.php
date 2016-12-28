<?php
namespace app\modules\admin\common\controllers;

use app\modules\admin\common\filters\AdminAuthFilter;
use Yii;
use app\modules\admin\models\AdminConst;
use app\models\b2b2c\VipCase;
use yii\web\UploadedFile;
use app\common\utils\image\ImageUtils;
use app\models\b2b2c\SysConfig;
use app\models\b2b2c\SysUploadFile;
use app\common\utils\DateUtils;
use app\common\utils\UrlUtils;
use yii\helpers\Json;
use app\common\utils\CommonUtils;
use app\models\b2b2c\VipCasePhoto;
use yii\helpers\Url;

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
		return array_merge(parent::behaviors(),[AdminAuthFilter::className(),
				/* 'authBehavior' => [
					'class' => AdminAuthBehavior::className(),
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
	
	
	/**
	 * 直接上传图片，不关联任何业务
	 * @return string
	 */
	public function actionCommonUpload() {
		$user_id = \Yii::$app->session->get ( AdminConst::LOGIN_ADMIN_USER )->id;
		$model = new VipCase(); //TODO VipCase要换成一个公用Model
	
		// 		$model->validate(['imageFiles']);
		// 		$error = $model->getErrors();
	
		// 案例相册
		//TODO：不一定能获取到图片
		$model->imageFiles = UploadedFile::getInstances ( $model, "imageFiles" );
		if ($model->imageFiles) {
			$imageUtils = new ImageUtils ();
			$image_type = 'tmp';
			$width = SysConfig::getInstance ()->getConfigVal ( "thumb_width" );
			$height = SysConfig::getInstance ()->getConfigVal ( "thumb_height" );
	
			// 处理案例相册
			// $model->imageFiles = UploadedFile::getInstances($model, "imageFiles");
			$vipCasePhotos = [ ];
			if (! empty ( $model->imageFiles )) {
				foreach ( $model->imageFiles as $galleryFile ) {
					if ($galleryFile) {
						$galleryFiles = $imageUtils->uploadImage ( $galleryFile, "uploads/$image_type", $image_type, CommonUtils::random ( 6 ), $width, $height,false );
						$vipcasePhoto = new VipCasePhoto ();
						// 						$vipcasePhoto->img_url = $galleryFiles ['img_url'];
						$vipcasePhoto->img_original = $galleryFiles ['img_original'];
						// 						$vipcasePhoto->thumb_url = $galleryFiles ['thumb_url'];
						$vipCasePhotos [] = $vipcasePhoto;
					}
				}
			}
	
	
			// 上传图片返回值
			$initialPreview = [ ];
			$initialPreviewConfig = [ ];
	
			// 插入相册信息
			if (! empty ( $vipCasePhotos )) {
				foreach ( $vipCasePhotos as $vipCasePhoto ) {
					$sysUploadFile = new SysUploadFile();
					$sysUploadFile->user_id = $user_id;
					$sysUploadFile->create_date = DateUtils::formatDatetime();
					$sysUploadFile->file_path = $vipCasePhoto->img_original;
					$sysUploadFile->session_id = Yii::$app->session->id;
					if (! ($sysUploadFile->save ())) {
						return Json::encode ( [
								'imageUrl' => '',
								'error' => \Yii::t('app', "upload_error"),
						] );
					}
	
					// 上传图片返回值
					$initialPreviewConfig [] = [
							'url' => Url::toRoute ( [
									'common-del-file',
									'id' => $sysUploadFile->id
							] ),
							// 图片大小
							'size' => filesize ( $vipCasePhoto->img_original ),
	
					];
					$initialPreview [] = UrlUtils::formatUrl ( $vipcasePhoto->img_original );
				}
			}
	
			return Json::encode ( [
					'initialPreview' => $initialPreview,
					'initialPreviewConfig' => $initialPreviewConfig,
					'error' => ''
			] );
	
		}
	
		return Json::encode ( [
				'imageUrl' => '',
				'error' => \Yii::t('app', "upload_error"),
		] );
	}
	
	
	/**
	 * 直接删除上传图片，不关联任何业务，但是只能删除自己上传的图片
	 * @return string
	 */
	public function actionCommonDelFile($id) {
	
		$user_id = \Yii::$app->session->get ( AdminConst::LOGIN_ADMIN_USER )->id;
	
		$sysUploadFile = SysUploadFile::findOne($id);
		if(empty($sysUploadFile)){
			return Json::encode ( [
					'success' => false
			] );
		}
	
		//只能删除自己上传的文件
		if($sysUploadFile->user_id != $user_id){
			return Json::encode ( [
					'success' => false
			] );
		}
	
		//删除记录
		$sysUploadFile->delete();
	
		//删除文件
		if(file_exists($sysUploadFile->file_path)){
			unlink($sysUploadFile->file_path);
		}
	
		return Json::encode ( [
				'success' => true
		] );
	}
	
}