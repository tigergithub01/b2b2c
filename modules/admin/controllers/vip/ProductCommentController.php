<?php

namespace app\modules\admin\controllers\vip;

use app\common\utils\MsgUtils;
use app\models\b2b2c\Product;
use app\models\b2b2c\ProductComment;
use app\models\b2b2c\search\ProductCommentSearch;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\Vip;
use app\modules\admin\common\controllers\BaseAuthController;
use Yii;
use yii\web\NotFoundHttpException;
use app\models\b2b2c\Activity;
use app\models\b2b2c\ProductCommentPhoto;
use app\modules\admin\models\AdminConst;
use app\common\utils\image\ImageUtils;
use app\models\b2b2c\SysConfig;
use yii\web\UploadedFile;
use app\common\utils\CommonUtils;

/**
 * ProductCommentController implements the CRUD actions for ProductComment model.
 */
class ProductCommentController extends BaseAuthController
{
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
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'cmtRankList' =>  SysParameterType::getSysParametersById(SysParameterType::CMT_RANK),
        ]);
    }

    /**
     * Displays a single ProductComment model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Creates a new VipBlog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new ProductComment();
    	$model->comment_date = \app\common\utils\DateUtils::formatDatetime();
    	$model->status = SysParameter::no;
    	$model->ip_addr = \Yii::$app->request->userIP;
    
    	if ($model->load(Yii::$app->request->post())/*  && $model->save() */) {
    		 
    		//处理帖子相册
    		$imageUtils = new ImageUtils();
    		$image_type = 'product_cmt';
    		$width = SysConfig::getInstance()->getConfigVal("thumb_width");
    		$height = SysConfig::getInstance()->getConfigVal("thumb_height");
    		$model->imageFiles = UploadedFile::getInstances($model, "imageFiles");
    		$prodCommentPhotos = [];
    		foreach ($model->imageFiles as $galleryFile) {
    			$galleryFiles = $imageUtils->uploadImage($galleryFile, "uploads/$image_type", $image_type,CommonUtils::random(6), $width, $height);
    			$prodCommentPhoto = new ProductCommentPhoto();
    			$prodCommentPhoto->img_url = $galleryFiles['img_url'];
    			$prodCommentPhoto->img_original = $galleryFiles['img_original'];
    			$prodCommentPhoto->thumb_url = $galleryFiles['thumb_url'];
    			$prodCommentPhotos[] = $prodCommentPhoto;
    		}
    		 
    		$transaction = ProductComment::getDb()->beginTransaction(); 
    		try {
    			/* 保存失败处理 */
    			if(!($model->save())){
    				$transaction->rollBack();
    				return $this->renderCreate($model);
    			}
    			 
    			//插入相册信息
    			if(!empty($prodCommentPhotos)){
    				foreach ($prodCommentPhotos as $prodCommentPhoto) {
    					$prodCommentPhoto->comment_id = $model->id;
    					if(!($prodCommentPhoto->save())){
    						$model->addError('imageFiles','图片上传失败');
    						$transaction->rollBack();
    						return $this->renderCreate($model);
    					}
    				}
    			}
    			 
    			$transaction->commit();
    			MsgUtils::success();
    			return $this->redirect(['view', 'id' => $model->id]);
    			 
    		}catch (\Exception $e) {
    			$transaction->rollBack();
    			// 	            throw $e;
    			$model->addError('content',$e->getMessage());
    			return $this->renderCreate($model);
    		}
    		 
    		 
    		MsgUtils::success();
    		return $this->redirect(['view', 'id' => $model->id]);
    	} /* else { */
    	return $this->renderCreate($model);
    	/*  } */
    }
    
    /**
     * @return Ambigous <string, string>
     */
    protected function renderCreate($model){
    	return $this->render('create', [
    			'model' => $model,
            	'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'vipList' => $this->findVipList(),
            	'productList' => $this->findProdctList(),
    			'activityList' => $this->findActivityList(),
            	'cmtRankList' =>  SysParameterType::getSysParametersById(SysParameterType::CMT_RANK),
    	]);
    }
    
    /**
     * Updates an existing VipBlog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$model = $this->findModel($id);
    
    	if ($model->load(Yii::$app->request->post())/*  && $model->save() */) {
    		//处理帖子相册
    		$imageUtils = new ImageUtils();
    		$image_type = 'product_cmt';
    		$width = SysConfig::getInstance()->getConfigVal("thumb_width");
    		$height = SysConfig::getInstance()->getConfigVal("thumb_height");
    		$model->imageFiles = UploadedFile::getInstances($model, "imageFiles");
    		$prodCommentPhotos = [];
    		foreach ($model->imageFiles as $galleryFile) {
    			$galleryFiles = $imageUtils->uploadImage($galleryFile, "uploads/$image_type", $image_type,CommonUtils::random(6), $width, $height);
    			$prodCommentPhoto = new ProductCommentPhoto();
    			$prodCommentPhoto->img_url = $galleryFiles['img_url'];
    			$prodCommentPhoto->img_original = $galleryFiles['img_original'];
    			$prodCommentPhoto->thumb_url = $galleryFiles['thumb_url'];
    			$prodCommentPhotos[] = $prodCommentPhoto;
    		}
    		 
    		$transaction = ProductComment::getDb()->beginTransaction();
    		try {
    			/* 保存失败处理 */
    			if(!($model->save())){
    				$transaction->rollBack();
    				return $this->renderUpdate($model);
    			}
    			 
    			//插入相册信息
    			if(!empty($prodCommentPhotos)){
    				foreach ($prodCommentPhotos as $prodCommentPhoto) {
    					$prodCommentPhoto->comment_id = $model->id;
    					if(!($prodCommentPhoto->save())){
    						$model->addError('imageFiles','图片上传失败');
    						$transaction->rollBack();
    						return $this->renderCreate();
    					}
    				}
    			}
    			 
    			$transaction->commit();
    			MsgUtils::success();
    			return $this->redirect(['view', 'id' => $model->id]);
    			 
    		}catch (\Exception $e) {
    			$transaction->rollBack();
    			// 	            throw $e;
    			$model->addError('content',$e->getMessage());
    			return $this->renderUpdate($model);
    		}
    		 
    		 
    		MsgUtils::success();
    		return $this->redirect(['view', 'id' => $model->id]);
    	}/*  else { */
    	return $this->renderUpdate($model);
    	/*  } */
    }

    /**
     * @return Ambigous <string, string>
     */
    protected function renderUpdate($model){
    	return $this->render('update', [
    			'model' => $model,
            	'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'vipList' => $this->findVipList(),
            	'productList' => $this->findProdctList(),
    			'activityList' => $this->findActivityList(),
            	'cmtRankList' =>  SysParameterType::getSysParametersById(SysParameterType::CMT_RANK),
    	]);
    }

    /**
     * Deletes an existing ProductComment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    
    /**
     * Deletes an existing VipCasePhoto model.
     * If deletion is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionDeleteProductCommentPhoto($id){
    	$productCommentPhoto = ProductCommentPhoto::findOne($id);
    	if(empty($productCommentPhoto)){
    		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
    	$productCommentPhoto->delete();
    
    	$thumb_url = iconv("UTF-8", "GBK", $productCommentPhoto->thumb_url);
    	$img_original = iconv("UTF-8", "GBK", $productCommentPhoto->img_original);
    	$img_url = iconv("UTF-8", "GBK", $productCommentPhoto->img_url);
    
    	if(is_file($thumb_url)){
    		unlink($thumb_url);
    	}
    	if(file_exists($img_original)){
    		unlink($img_original);
    	}
    	if(file_exists($img_url)){
    		unlink($img_url);
    	}
    	MsgUtils::success();
    	return $this->redirect(['view','id'=>$productCommentPhoto->comment_id]);
    }

    /**
     * Finds the ProductComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        
    	$model = ProductComment::find()->alias('pcmt')
    	->joinWith('status0 stat')
    	->joinWith('cmtRank cmtRank')
    	->joinWith('parent parent')
    	->joinWith('vip vip')
    	->joinWith('product prod')
    	->joinWith('order order')
    	->joinWith('package package')
    	->where(['pcmt.id'=>$id])->one();
    	if($model){
//     	if (($model = ProductComment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    /***
      @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipList(){
    	return Vip::find()->where(['merchant_flag'=>SysParameter::no])->all();
    }
    
    /***
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findProdctList(){
    	return Product::find()->all();
    }
    
    /***
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findActivityList(){
    	return Activity::find()->all();
    }
}
