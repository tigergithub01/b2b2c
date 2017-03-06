<?php

namespace app\modules\vip\controllers\api\member\vip;

use app\common\utils\CommonUtils;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\ProductComment;
use app\models\b2b2c\search\ProductCommentSearch;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\Vip;
use app\modules\vip\common\controllers\BaseAuthApiController;
use Yii;
use yii\helpers\ArrayHelper;
use app\modules\vip\models\VipConst;
use app\common\utils\image\ImageUtils;
use app\models\b2b2c\SysConfig;
use yii\web\UploadedFile;
use app\models\b2b2c\SoSheet;
use app\modules\vip\service\order\SoSheetService;
use app\models\b2b2c\ProductCommentPhoto;

/**
 * ProductCommentController implements the CRUD actions for ProductComment model.
 */
class ProductCommentController extends BaseAuthApiController {
	/**
	 * @inheritdoc
	 */
	/*
	 public function behaviors()
	 {
	 return [
	 'verbs' => [
	 'class' => VerbFilter::className(),
	 'actions' => [
	 'delete' => ['POST'],
	 ],
	 ],
	 ];
	 }
	 */
	
	/**
	 * Lists all ProductComment models.
	 * 
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new ProductCommentSearch ();
		$searchModel->status = SysParameter::yes;
		$dataProvider = $searchModel->search ( Yii::$app->request->queryParams );
		
		$models = $dataProvider->getModels ();
		
		// 格式化输出
		$data = ArrayHelper::toArray ( $models, [ 
				ProductComment::className () => array_merge ( CommonUtils::getModelFields ( new ProductComment () ), [ 
						'vip_name' => function ($value) {
							return (empty ( $value->vip ) ? '' : $value->vip->vip_name);
						},
						'thumb_url' => function ($value) {
							return (empty ( $value->vip ) ? '' : $value->vip->thumb_url);
						} 
				] ) 
		] );
		
		$pagionationObj = new PaginationObj ( $data, $dataProvider->getTotalCount () );
		return CommonUtils::json_success ( $pagionationObj );
	}
	
	/**
	 * Creates a new VipBlog model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @return mixed
	 */
	public function actionCreate() {
		$vip_id = \Yii::$app->session->get ( VipConst::LOGIN_VIP_USER )->id;
		
		$model = new ProductComment ();
		$model->comment_date = \app\common\utils\DateUtils::formatDatetime();
		$model->status = SysParameter::yes;
		$model->ip_addr = \Yii::$app->request->userIP;
		$model->vip_id = $vip_id;
		
		if ($model->load ( Yii::$app->request->post () )/*  && $model->save() */) {
			
			if(empty($model->order_id)){
				return CommonUtils::json_failed("订单编号不能为空！");
			}
			
			$order = SoSheet::findOne($model->order_id);
			if(empty($order)){
				return CommonUtils::json_failed("订单不存在！");
			}
			
			$soSheetService = new SoSheetService ();
			$jsonObj = $soSheetService->getSoSheetCmtAuth ( $order, $vip_id ); // 判断权限
			if (! ($jsonObj->status)) {
				return CommonUtils::json_failed ( $jsonObj->message );
			}
			
			
			// 处理帖子相册
			$imageUtils = new ImageUtils ();
			$image_type = 'product_cmt';
			$width = SysConfig::getInstance ()->getConfigVal ( "thumb_width" );
			$height = SysConfig::getInstance ()->getConfigVal ( "thumb_height" );
			$model->imageFiles = UploadedFile::getInstances ( $model, "imageFiles" );
			$prodCommentPhotos = [ ];
			foreach ( $model->imageFiles as $galleryFile ) {
				$galleryFiles = $imageUtils->uploadImage ( $galleryFile, "uploads/$image_type", $image_type, CommonUtils::random ( 6 ), $width, $height );
				$prodCommentPhoto = new ProductCommentPhoto ();
				$prodCommentPhoto->img_url = $galleryFiles ['img_url'];
				$prodCommentPhoto->img_original = $galleryFiles ['img_original'];
				$prodCommentPhoto->thumb_url = $galleryFiles ['thumb_url'];
				$prodCommentPhotos [] = $prodCommentPhoto;
			}
			
			$transaction = ProductComment::getDb ()->beginTransaction ();
			try {
				/* 保存失败处理 */
				if (! ($model->save ())) {
					$transaction->rollBack ();
					return $this->renderCreate ( $model );
				}
				
				// 插入相册信息
				if (! empty ( $prodCommentPhotos )) {
					foreach ( $prodCommentPhotos as $prodCommentPhoto ) {
						$prodCommentPhoto->comment_id = $model->id;
						if (! ($prodCommentPhoto->save ())) {
							$model->addError ( 'imageFiles', '图片上传失败' );
							$transaction->rollBack ();
							return $this->renderCreate ( $model );
						}
					}
				}
				
				$transaction->commit ();
				return CommonUtils::json_success ( $model->id );
			} catch ( \Exception $e ) {
				$transaction->rollBack ();
				// throw $e;
				$model->addError ( 'content', $e->getMessage () );
				return $this->renderCreate ( $model );
			}
			
			return CommonUtils::json_success ( $model->id );
		} /* else { */
		return $this->renderCreate ( $model );
		/*  } */
	}
	
	/**
	 *
	 * @return Ambigous <string, string>
	 */
	protected function renderCreate($model) {
		return CommonUtils::jsonModel_failed ( $model );
	}
	
	/**
	 * Updates an existing VipBlog model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * 
	 * @param string $id        	
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel ( $id );
		
		$model->imageFiles = UploadedFile::getInstances ( $model, "imageFiles" );		
		
		if ($model->load ( Yii::$app->request->post () ) || $model->imageFiles/*  && $model->save() */) {
			
			// 处理帖子相册
			$imageUtils = new ImageUtils ();
			$image_type = 'product_cmt';
			$width = SysConfig::getInstance ()->getConfigVal ( "thumb_width" );
			$height = SysConfig::getInstance ()->getConfigVal ( "thumb_height" );
			
			$prodCommentPhotos = [ ];
			foreach ( $model->imageFiles as $galleryFile ) {
				$galleryFiles = $imageUtils->uploadImage ( $galleryFile, "uploads/$image_type", $image_type, CommonUtils::random ( 6 ), $width, $height );
				$prodCommentPhoto = new ProductCommentPhoto ();
				$prodCommentPhoto->img_url = $galleryFiles ['img_url'];
				$prodCommentPhoto->img_original = $galleryFiles ['img_original'];
				$prodCommentPhoto->thumb_url = $galleryFiles ['thumb_url'];
				$prodCommentPhotos [] = $prodCommentPhoto;
			}
			
			$transaction = ProductComment::getDb ()->beginTransaction ();
			try {
				/* 保存失败处理 */
				if (! ($model->save ())) {
					$transaction->rollBack ();
					return $this->renderUpdate ( $model );
				}
				
				// 插入相册信息
				if (! empty ( $prodCommentPhotos )) {
					foreach ( $prodCommentPhotos as $prodCommentPhoto ) {
						$prodCommentPhoto->comment_id = $model->id;
						if (! ($prodCommentPhoto->save ())) {
							$model->addError ( 'imageFiles', '图片上传失败' );
							$transaction->rollBack ();
							return $this->renderCreate ();
						}
					}
				}
				
				$transaction->commit ();
				
				return CommonUtils::json_success ( $model->id );
			} catch ( \Exception $e ) {
				$transaction->rollBack ();
				// throw $e;
				$model->addError ( 'content', $e->getMessage () );
				return $this->renderUpdate ( $model );
			}
			
			return CommonUtils::json_success ( $model->id );
		} /*  else { */
		return $this->renderUpdate ( $model );
		/*  } */
	}
	
	/**
	 *
	 * @return Ambigous <string, string>
	 */
	protected function renderUpdate($model) {
		return CommonUtils::jsonModel_failed ( $model );
	}
	
	/**
	 * Displays a single ProductComment model.
	 * 
	 * @param string $id        	
	 * @return mixed
	 */
	public function actionView() {
		$id = isset ( $_REQUEST ['id'] ) ? $_REQUEST ['id'] : null;
		$model = $this->findModel ( $id );
		
		return CommonUtils::json_success ( $model );
	}
	
	/**
	 * Finds the ProductComment model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * 
	 * @param string $id        	
	 * @return ProductComment the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		$model = ProductComment::find ()->alias ( 'pcmt' )->joinWith ( 'status0 stat' )->joinWith ( 'cmtRank cmtRank' )->joinWith ( 'parent parent' )->joinWith ( 'vip vip' )->joinWith ( 'product prod' )->where ( [ 
				'pcmt.id' => $id 
		] )->one ();
		
		return $model;
	}
}
