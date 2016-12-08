<?php

namespace app\modules\merchant\controllers\blog;

use Yii;
use app\models\b2b2c\VipBlog;
use app\models\b2b2c\search\VipBlogSearch;
use app\modules\merchant\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\Vip;
use app\models\b2b2c\VipBlogType;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\SysParameter;
use app\common\utils\image\ImageUtils;
use yii\web\UploadedFile;
use app\models\b2b2c\VipBlogPhoto;
use app\models\b2b2c\SysConfig;
use app\common\utils\CommonUtils;
use app\modules\merchant\models\MerchantConst;

/**
 * VipBlogController implements the CRUD actions for VipBlog model.
 */
class VipBlogController extends BaseAuthController
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
     * Lists all VipBlog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipBlogSearch();
        $searchModel->vip_id = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
        $searchModel->status=SysParameter::yes;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'vipList' => $this->findVipList(),
        		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
        		'blogFlagList' => SysParameterType::getSysParametersById(SysParameterType::BLOG_FLAG),
        		'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
        		'vipBlogTypeList' => $this->findVipBlogTypeList(),
        ]);
    }

    /**
     * Displays a single VipBlog model.
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
    	//TODO:根据状态判断能否提交
    	$vip_id = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
    	$vip = Vip::findOne($vip_id);
    	if($vip->audit_status!=SysParameter::audit_approved){
    		MsgUtils::warning("营业信息审核通过后，才能提交！");
    		return $this->redirect(['index']);
    	}
    	
    	$model = new VipBlog();
        $model->create_date = \app\common\utils\DateUtils::formatDatetime();
        $model->update_date = \app\common\utils\DateUtils::formatDatetime();
        $model->audit_status = SysParameter::audit_need_approve;
        $model->status = SysParameter::yes;
        $model->blog_flag = VipBlog::blog_flag_merchant;
        $model->vip_id = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
        
        if ($model->load(Yii::$app->request->post())/*  && $model->save() */) {
        	
        	//处理帖子相册
        	$imageUtils = new ImageUtils();
        	$image_type = 'vip_blog';
        	$width = SysConfig::getInstance()->getConfigVal("thumb_width");
        	$height = SysConfig::getInstance()->getConfigVal("thumb_height");
        	$model->imageFiles = UploadedFile::getInstances($model, "imageFiles");
        	$vipBlogPhotos = [];
        	foreach ($model->imageFiles as $galleryFile) {
        		$galleryFiles = $imageUtils->uploadImage($galleryFile, "uploads/$image_type", $image_type,CommonUtils::random(6), $width, $height);
        		$vipBlogPhoto = new VipBlogPhoto();
        		$vipBlogPhoto->img_url = $galleryFiles['img_url'];
        		$vipBlogPhoto->img_original = $galleryFiles['img_original'];
        		$vipBlogPhoto->thumb_url = $galleryFiles['thumb_url'];
        		$vipBlogPhotos[] = $vipBlogPhoto;
        	}
        	
        	$transaction = VipBlog::getDb()->beginTransaction();
        	try {
        		/* 保存失败处理 */
        		if(!($model->save())){
        			$transaction->rollBack();
        			return $this->renderCreate();
        		}
        	
        		//插入相册信息
        		if(!empty($vipBlogPhotos)){
        			foreach ($vipBlogPhotos as $vipBlogPhoto) {
        				$vipBlogPhoto->blog_id = $model->id;
        				if(!($vipBlogPhoto->save())){
        					$model->addError('imageFiles','帖子图片上传失败');
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
        		$model->addError('name',$e->getMessage());
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
            		'vipList' => $this->findVipList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'blogFlagList' => SysParameterType::getSysParametersById(SysParameterType::BLOG_FLAG),
            		'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            		'vipBlogTypeList' => $this->findVipBlogTypeList(),
            		'sysUserList' => $this->findSysUserList(),
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
        	$image_type = 'vip_blog';
        	$width = SysConfig::getInstance()->getConfigVal("thumb_width");
        	$height = SysConfig::getInstance()->getConfigVal("thumb_height");
        	$model->imageFiles = UploadedFile::getInstances($model, "imageFiles");
        	$vipBlogPhotos = [];
        	foreach ($model->imageFiles as $galleryFile) {
        		$galleryFiles = $imageUtils->uploadImage($galleryFile, "uploads/$image_type", $image_type,CommonUtils::random(6), $width, $height);
        		$vipBlogPhoto = new VipBlogPhoto();
        		$vipBlogPhoto->img_url = $galleryFiles['img_url'];
        		$vipBlogPhoto->img_original = $galleryFiles['img_original'];
        		$vipBlogPhoto->thumb_url = $galleryFiles['thumb_url'];
        		$vipBlogPhotos[] = $vipBlogPhoto;
        	}
        	
        	$transaction = VipBlog::getDb()->beginTransaction();
        	try {
        		/* 保存失败处理 */
        		if(!($model->save())){
        			$transaction->rollBack();
        			return $this->renderUpdate($model);
        		}
        		 
        		//插入相册信息
        		if(!empty($vipBlogPhotos)){
        			foreach ($vipBlogPhotos as $vipBlogPhoto) {
        				$vipBlogPhoto->blog_id = $model->id;
        				if(!($vipBlogPhoto->save())){
        					$model->addError('imageFiles','帖子图片上传失败');
        					$transaction->rollBack();
        					return $this->renderUpdate($model);
        				}
        			}
        		}
        		 
        		$transaction->commit();
        		MsgUtils::success();
        		return $this->redirect(['view', 'id' => $model->id]);
        		 
        	}catch (\Exception $e) {
        		$transaction->rollBack();
        		// 	            throw $e;
        		$model->addError('name',$e->getMessage());
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
            	'vipList' => $this->findVipList(),
            	'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'blogFlagList' => SysParameterType::getSysParametersById(SysParameterType::BLOG_FLAG),
            	'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            	'vipBlogTypeList' => $this->findVipBlogTypeList(),
            	'sysUserList' => $this->findSysUserList(),
            ]);
    }

    /**
     * Deletes an existing VipBlog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	
    	$model = $this->findModel($id);
    	
    	//TODO: 判断权限
    	$vip_id = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
    	if($model->vip_id != $vip_id){
    		MsgUtils::error("非法操作！");
    		return $this->redirect(['index']);
    	}
    	
    	//开始事务
    	$transaction = VipBlog::getDb()->beginTransaction();
    	try {
	    	//删除blog图片
	    	$vipBlogPhotos = VipBlogPhoto::find()->where(['blog_id' => $model->id])->all();
	    	foreach ($vipBlogPhotos as $vipBlogPhoto) {
	    		$thumb_url = iconv("UTF-8", "GBK", $vipBlogPhoto->thumb_url);
	    		$img_original = iconv("UTF-8", "GBK", $vipBlogPhoto->img_original);
	    		$img_url = iconv("UTF-8", "GBK", $vipBlogPhoto->img_url);
	    		 
	    		if(is_file($thumb_url)){
	    			unlink($thumb_url);
	    		}
	    		if(file_exists($img_original)){
	    			unlink($img_original);
	    		}
	    		if(file_exists($img_url)){
	    			unlink($img_url);
	    		}
	    		$vipBlogPhoto->delete();
	    	}
	    	
	    	//删除
	    	$model->delete();
	    	$transaction->commit();	    	
    	}catch (\Exception $e) {
    		$transaction->rollBack();
    		MsgUtils::error("删除失败!");
    		return $this->redirect(['index']);
    	}
    	 
    	MsgUtils::success();
    	return $this->redirect(['index']);
    }
    
    /**
     * Deletes an existing VipCasePhoto model.
     * If deletion is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionDeleteVipBlogPhoto($id){
    	$vipBlogPhoto = VipBlogPhoto::findOne($id);
    	if(empty($vipBlogPhoto)){
    		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
    	$vipBlogPhoto->delete();
    	 
    	$thumb_url = iconv("UTF-8", "GBK", $vipBlogPhoto->thumb_url);
    	$img_original = iconv("UTF-8", "GBK", $vipBlogPhoto->img_original);
    	$img_url = iconv("UTF-8", "GBK", $vipBlogPhoto->img_url);
    
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
    	return $this->redirect(['view','id'=>$vipBlogPhoto->blog_id]);
    }

    /**
     * Finds the VipBlog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VipBlog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = VipBlog::find()->alias('vipBlog')
    	->joinWith('vip vip')
    	->joinWith('status0 stat')
    	->joinWith('blogFlag blogFlag')
    	->joinWith('blogType blogType')
    	->joinWith('auditStatus auditStatus')
    	->joinWith('auditUser auditUser')
    	->where(['vipBlog.id'=>$id])->one();
    	
    	if($model){
//         if (($model = VipBlog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findVipList(){
    	$vipList = Vip::find()->all();
    	foreach ($vipList as $key => $model) {
    		$model->vip_id = $model->vip_id . (($model->merchant_flag==SysParameter::yes)?'(商户)':'(会员)');
    	}
    	return $vipList;
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipBlogTypeList(){
    	return VipBlogType::find()->all();
    }
    
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findSysUserList(){
    	return SysUser::find()->all();
    }
}
