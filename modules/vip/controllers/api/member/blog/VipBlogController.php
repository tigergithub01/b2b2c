<?php

namespace app\modules\vip\controllers\api\member\blog;

use app\common\utils\CommonUtils;
use app\models\b2b2c\SysConfig;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\VipBlog;
use app\modules\vip\common\controllers\BaseAuthApiController;
use app\modules\vip\models\VipConst;
use Yii;
use yii\web\UploadedFile;
use app\common\utils\image\ImageUtils;

/**
 * VipBlogController implements the CRUD actions for VipBlog model.
 */
class VipBlogController extends BaseAuthApiController
{
    
    /**
     * Creates a new VipBlog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new VipBlog();
    	
    	$model->create_date = date(VipConst::DATE_FORMAT, time());
    	$model->update_date = date(VipConst::DATE_FORMAT, time());
    	$model->audit_status = SysParameter::audit_need_approve;
    	$model->status = SysParameter::no;
    	$model->vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
    
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
    				return CommonUtils::jsonModel_failed($model);
    			}
    			 
    			//插入相册信息
    			if(!empty($vipBlogPhotos)){
    				foreach ($vipBlogPhotos as $vipBlogPhoto) {
    					$vipBlogPhoto->blog_id = $model->id;
    					if(!($vipBlogPhoto->save())){
    						$model->addError('imageFiles','帖子图片上传失败');
    						$transaction->rollBack();
    						return CommonUtils::jsonModel_failed($model);
    					}
    				}
    			}
    			 
    			$transaction->commit();
    			return CommonUtils::json_success($model->id);
    			 
    		}catch (\Exception $e) {
    			$transaction->rollBack();
    			$model->addError('name',$e->getMessage());
    			return CommonUtils::jsonModel_failed($model);
    		}
    	} 
    	return CommonUtils::jsonModel_failed($model);
    }

}