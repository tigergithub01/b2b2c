<?php

namespace app\modules\admin\controllers\basic;

use app\common\utils\MsgUtils;
use app\models\b2b2c\Product;
use app\models\b2b2c\ProductBrand;
use app\models\b2b2c\ProductType;
use app\models\b2b2c\search\ProductSearch;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\Vip;
use app\modules\admin\common\controllers\BaseAuthController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\common\utils\image\ImageUtils;
use app\models\b2b2c\SysConfig;
use app\models\b2b2c\ProductGallery;
use app\common\utils\UrlUtils;
use yii\helpers\Json;
use app\common\utils\CommonUtils;
use yii\helpers\Url;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BaseAuthController
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'ptypeList' => $this->findPtypeList(),
        	'pbrandList' => $this->findPbrandList(),
        	'vipList' => $this->findVipList(),
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $model->is_on_sale = Product::is_on_sale_no;
        $model->is_hot = SysParameter::yes;
        $model->audit_status = SysParameter::audit_approved;
        $model->can_return_flag = SysParameter::yes;
        $model->is_free_shipping = SysParameter::no;
        
        /* $s = base64_decode(str_replace('data:image/png;base64,', '', $_POST['uploadFile']));
        file_put_contents('1.png', $s); */
        
        if ($model->load(Yii::$app->request->post())/*  && $model->save() */) {
        	 
        	$model->imageFile = UploadedFile::getInstance($model, "imageFile");
        
        	//处理图片
        	$imageUtils = new ImageUtils();
        	$image_type = 'product';
        	$width = SysConfig::getInstance()->getConfigVal("thumb_width");
        	$height = SysConfig::getInstance()->getConfigVal("thumb_height");
        
        	if($files = ($imageUtils->uploadImage($model->imageFile, "uploads/$image_type", $image_type,null, $width, $height))){
        		$model->img_url = $files['img_url'];
        		$model->img_original = $files['img_original'];
        		$model->thumb_url = $files['thumb_url'];
        	}
        	 
        	 
        	//处理案例相册
        	$model->imageFiles = UploadedFile::getInstances($model, "imageFiles");
        	$productPhotos = [];
        	foreach ($model->imageFiles as $galleryFile) {
        		$galleryFiles = $imageUtils->uploadImage($galleryFile, "uploads/$image_type", $image_type,CommonUtils::random(6), $width, $height);
        		$productPhoto = new ProductGallery();
        		$productPhoto->img_url = $galleryFiles['img_url'];
        		$productPhoto->img_original = $galleryFiles['img_original'];
        		$productPhoto->thumb_url = $galleryFiles['thumb_url'];
        		$productPhotos[] = $productPhoto;
        	}
        	 
        	//开始保存事务
        	$transaction = Product::getDb()->beginTransaction();
        	try {
        		/* 保存失败处理 */
        		if(!($model->save())){
        			$transaction->rollBack();
        			return $this->renderCreate();
        		}
        
        		//插入相册信息
        		if(!empty($productPhotos)){
        			foreach ($productPhotos as $productPhoto) {
        				$productPhoto->product_id = $model->id;
        				if(!($productPhoto->save())){
        					$model->addError('imageFiles','产品相册上传失败');
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
        		$model->addError('name',$e->getMessage());
        		return $this->renderCreate($model);
        	}
        	 
        }
        return $this->renderCreate($model);
    }
    
    
    /**
     * @return Ambigous <string, string>
     */
    protected function renderCreate($model){
    	return $this->render('create', [
    			'model' => $model,
    			'ptypeList' => $this->findPtypeList(),
            	'pbrandList' => $this->findPbrandList(),
            	'vipList' => $this->findVipList(),
            	'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'pStatusList' => SysParameterType::getSysParametersById(SysParameterType::PRODUCT_STATUS),
            	'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
    			'initialPreview' => [ ],
    			'initialPreviewConfig' => [ ],
    			'initialPreviewCover' => [ ]
    	]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        // 案例相册
        if ($model->load ( Yii::$app->request->post () )) {
        	// 获取案例封面信息
        	$model->imageFile = UploadedFile::getInstance ( $model, 'imageFile' );
        		
        	$imageUtils = new ImageUtils ();
        	$image_type = 'photo';
        	$width = SysConfig::getInstance ()->getConfigVal ( "thumb_width" );
        	$height = SysConfig::getInstance ()->getConfigVal ( "thumb_height" );
        		
        	// 旧图片地址
        	$old_img_url = $model->img_url;
        	$old_img_original = $model->img_original;
        	$old_thumb_url = $model->thumb_url;
        		
        	if ($files = ($imageUtils->uploadImage ( $model->imageFile, "uploads/$image_type", $image_type, $model->id, $width, $height ))) {
        		// 新图片地址
        		$model->img_url = $files ['img_url'];
        		$model->img_original = $files ['img_original'];
        		$model->thumb_url = $files ['thumb_url'];
        	}
        		
        	$transaction = Product::getDb ()->beginTransaction ();
        	try {
        		if (! ($model->save ())) {
        			$transaction->rollBack ();
        			return $this->renderUpdate ();
        		}
        
        		if ($files) {
        			// 删除旧图片
        			if (file_exists ( $old_img_url )) {
        				unlink ( $old_img_url );
        			}
        			if (file_exists ( $old_img_original )) {
        				unlink ( $old_img_original );
        			}
        			if (file_exists ( $old_thumb_url )) {
        				unlink ( $old_thumb_url );
        			}
        		}
        
        
        		$transaction->commit ();
        		MsgUtils::success ();
        		return $this->redirect ( [
        				'view',
        				'id' => $model->id
        		] );
        	} catch ( \Exception $e ) {
        		$transaction->rollBack ();
        		$model->addError ( 'name', $e->getMessage () );
        		return $this->renderUpdate ( $model );
        	}
        }
        
        // if ($model->load(Yii::$app->request->post()) /* && $model->save() */) {
        // MsgUtils::success();
        // return $this->redirect(['view', 'id' => $model->id]);
        // } else {
        
        return $this->renderUpdate ( $model );
        
    }
    
    
    /**
     *
     * @return Ambigous <string, string>
     */
    protected function renderUpdate($model) {
    	//图片
    	$initialPreview = [ ];
    	$initialPreviewConfig = [ ];
    	foreach ( $model->productGalleries as $vipCasePhoto ) {
    		$initialPreview [] = UrlUtils::formatUrl ( $vipCasePhoto->thumb_url );
    		$initialPreviewConfig [] = [
    				// 要删除商品图的地址
    				'url' => Url::toRoute ( [
    						'delete-product-gallery-photo',
    						'id' => $vipCasePhoto->id
    				] ),
    				// 图片大小
    				'size' => filesize ( $vipCasePhoto->img_url )
    		];
    	}
    
    	// 封面
    	$initialPreviewCover = [ ];
    	if ($model->thumb_url) {
    		$initialPreviewCover [] = UrlUtils::formatUrl ( $model->thumb_url );
    	}
    
    	return $this->render ( 'update', [
    			'model' => $model,
    			'ptypeList' => $this->findPtypeList(),
            		'pbrandList' => $this->findPbrandList(),
            		'vipList' => $this->findVipList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'pStatusList' => SysParameterType::getSysParametersById(SysParameterType::PRODUCT_STATUS),
            		'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
    			'initialPreview' => $initialPreview,
    			'initialPreviewConfig' => $initialPreviewConfig,
    			'initialPreviewCover' => $initialPreviewCover
    	] );
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$model = $this->findModel ( $id );
    	
    	// 开始事务
    	$transaction = Product::getDb ()->beginTransaction ();
    	try {
    		// 删除图片
    		$photos = ProductGallery::find ()->where ( [
    				'case_id' => $id
    		] )->all ();
    		foreach ( $photos as $photo ) {
    			$thumb_url = iconv ( "UTF-8", "GBK", $photo->thumb_url );
    			$img_original = iconv ( "UTF-8", "GBK", $photo->img_original );
    			$img_url = iconv ( "UTF-8", "GBK", $photo->img_url );
    	
    			if (is_file ( $thumb_url )) {
    				unlink ( $thumb_url );
    			}
    			if (file_exists ( $img_original )) {
    				unlink ( $img_original );
    			}
    			if (file_exists ( $img_url )) {
    				unlink ( $img_url );
    			}
    			$photo->delete ();
    		}
    			
    		// 删除文字内容
    		$model->delete ();
    			
    		$transaction->commit ();
    	} catch ( \Exception $e ) {
    		$transaction->rollBack ();
    		MsgUtils::error ( "删除失败!" );
    		return $this->redirect ( [
    				'index'
    		] );
    	}
    	
    	MsgUtils::success ();
    	return $this->redirect ( [
    			'index'
    	] );
    	
    	/* $this->findModel($id)->delete();
		MsgUtils::success();
        return $this->redirect(['index']); */
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = Product::find()->alias('p')
    	->joinWith('type tp')
    	->joinWith('brand bd')
    	->joinWith('vip vip')
    	->joinWith('isOnSale onSale')
    	->joinWith('isHot hot')
    	->joinWith('auditStatus audit')
    	->joinWith('canReturnFlag rt')
    	->joinWith('isFreeShipping free')
    	->where(['p.id' => $id])->one();
    	if($model !==null){
//     	if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    
    /**
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findPtypeList(){
    	return ProductType::find()->all();
    }
    
    
    /**
     * 
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findPbrandList(){
    	return ProductBrand::find()->all();
    }
    
    /**
     * 
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipList(){
    	return Vip::find()->where(['merchant_flag'=>SysParameter::yes])->all();
    }
    
    
    /**
     * Updates an existing VipCase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     * @return mixed
     */
    public function actionUpload1($id) {
    	$model = $this->findModel ( $id );
    
    	// 案例相册
    	$model->imageFiles = UploadedFile::getInstances ( $model, "imageFiles" ); 
    
    	if ($model->imageFiles) {
    			
    		$imageUtils = new ImageUtils ();
    		$image_type = 'product';
    		$width = SysConfig::getInstance ()->getConfigVal ( "thumb_width" );
    		$height = SysConfig::getInstance ()->getConfigVal ( "thumb_height" );
    			
    		// 处理案例相册
    		// $model->imageFiles = UploadedFile::getInstances($model, "imageFiles");
    		$productPhotos = [ ];
    		if (! empty ( $model->imageFiles )) {
    			foreach ( $model->imageFiles as $galleryFile ) {
    				if ($galleryFile) {
    					$galleryFiles = $imageUtils->uploadImage ( $galleryFile, "uploads/$image_type", $image_type, CommonUtils::random ( 6 ), $width, $height );
    					$productGallery = new ProductGallery();
    					$productGallery->img_original = $galleryFiles ['img_original'];
    					$productGallery->img_url = $galleryFiles ['img_url'];
    					$productGallery->thumb_url = $galleryFiles ['thumb_url'];
    					$productPhotos [] = $productGallery;
    				}
    			}
    		}
    			
    		$transaction = Product::getDb ()->beginTransaction ();
    		try {
    			// 上传图片返回值
    			$initialPreview = [ ];
    			$initialPreviewConfig = [ ];
    
    			// 插入相册信息
    			if (! empty ( $productPhotos )) {
    				foreach ( $productPhotos as $productPhoto ) {
    					$productPhoto->product_id = $model->id;
    					if (! ($productPhoto->save ())) {
    						$model->addError ( 'imageFiles', \Yii::t('app', "upload_error"));
    						$transaction->rollBack ();
    						return Json::encode ( [
    								'imageUrl' => '',
    								'error' => \Yii::t('app', "upload_error"),
    						] );
    					}
    
    					// 上传图片返回值
    					$initialPreviewConfig [] = [
    							'url' => Url::toRoute ( [
    									'delete-product-gallery-photo',
    									'id' => $productPhoto->id
    							] ),
    
    					];
    					$initialPreview [] = UrlUtils::formatUrl ( $productPhoto->img_original );
    				}
    			}
    
    			$transaction->commit ();
    
    			return Json::encode ( [
    					'initialPreview' => $initialPreview,
    					'initialPreviewConfig' => $initialPreviewConfig,
    					'error' => ''
    			] );
    
    		} catch ( \Exception $e ) {
    			$transaction->rollBack ();
    			return Json::encode ( [
    					'imageUrl' => '',
    					'error' => \Yii::t('app', "upload_error"),
    			] );
    		}
    	}
    
    	return Json::encode ( [
    			'imageUrl' => '',
    			'error' => \Yii::t('app', "upload_error"),
    	] );
    }
    
    /**
     * Deletes an existing VipCasePhoto model.
     * If deletion is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     * @return mixed
     */
    public function actionDeleteProductGalleryPhoto($id) {
    	$photo = ProductGallery::findOne ( $id );
    	if (empty ( $photo )) {
    		throw new NotFoundHttpException ( Yii::t ( 'app', 'The requested page does not exist.' ) );
    	}
    	$photo->delete ();
    
    	$thumb_url = iconv ( "UTF-8", "GBK", $photo->thumb_url );
    	$img_original = iconv ( "UTF-8", "GBK", $photo->img_original );
    	$img_url = iconv ( "UTF-8", "GBK", $photo->img_url );
    
    	if (is_file ( $thumb_url )) {
    		unlink ( $thumb_url );
    	}
    	if (file_exists ( $img_original )) {
    		unlink ( $img_original );
    	}
    	if (file_exists ( $img_url )) {
    		unlink ( $img_url );
    	}
    	if (Yii::$app->getRequest ()->getIsAjax ()) {
    		return Json::encode ( [
    				'success' => true
    		] );
    	} else {
    		MsgUtils::success ();
    		return $this->redirect ( [
    				'view',
    				'id' => $photo->product_id
    		] );
    	}
    }
    
    
}
