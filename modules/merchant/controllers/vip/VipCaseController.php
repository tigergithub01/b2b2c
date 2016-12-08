<?php

namespace app\modules\merchant\controllers\vip;

use Yii;
use app\models\b2b2c\VipCase;
use app\models\b2b2c\search\VipCaseSearch;
use app\modules\merchant\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\VipCaseType;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysUser;
use yii\web\UploadedFile;
use app\common\utils\image\ImageUtils;
use app\models\b2b2c\SysConfig;
use app\models\b2b2c\common\Constant;
use app\modules\admin\models\AdminConst;
use app\models\b2b2c\VipCasePhoto;
use app\common\utils\CommonUtils;
use app\modules\merchant\models\MerchantConst;

/**
 * VipCaseController implements the CRUD actions for VipCase model.
 */
class VipCaseController extends BaseAuthController
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
     * Lists all VipCase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipCaseSearch();
        $merchant_user = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER);
        $vip_id = $merchant_user->id;
        $searchModel->vip_id = $vip_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        			'vipCaseTypeList' => $this->findVipCaseTypeList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            		'caseFlagList' => SysParameterType::getSysParametersById(SysParameterType::CASE_FLAG),
            		'vipList' => $this->findVipList(),
            		'sysUserList' => $this->findSysUserList(),
        ]);
    }

    /**
     * Displays a single VipCase model.
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
     * Creates a new VipCase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$merchant_user = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER);
    	$vip_id = $merchant_user->id;
        $model = new VipCase();
        $model->create_date = \app\common\utils\DateUtils::formatDatetime();
        $model->update_date= \app\common\utils\DateUtils::formatDatetime();
        $model->is_hot = SysParameter::no;
        $model->status = SysParameter::yes;
        $model->audit_status = SysParameter::audit_need_submit;
        $model->vip_id = $vip_id;
        $vipCaseType = $this->findVipCaseTypeByVipTypeId($merchant_user->vip_type_id);
        if($vipCaseType){
        	$model->type_id = $vipCaseType->id;
        }
        
        
        if ($model->load(Yii::$app->request->post())/*  && $model->save() */) {
        	
        	$model->imageFile = UploadedFile::getInstance($model, "imageFile");
        	 
        	//处理图片
        	$imageUtils = new ImageUtils();
        	$image_type = 'vip_case';
        	$width = SysConfig::getInstance()->getConfigVal("thumb_width");
        	$height = SysConfig::getInstance()->getConfigVal("thumb_height");
        	 
        	if($files = ($imageUtils->uploadImage($model->imageFile, "uploads/$image_type", $image_type,null, $width, $height))){
        		$model->cover_img_url = $files['img_url'];
        		$model->cover_img_original = $files['img_original'];
        		$model->cover_thumb_url = $files['thumb_url'];
        	}
        	
        	
        	//处理案例相册
        	$model->imageFiles = UploadedFile::getInstances($model, "imageFiles");
        	$vipCasePhotos = [];
        	foreach ($model->imageFiles as $galleryFile) {
        		$galleryFiles = $imageUtils->uploadImage($galleryFile, "uploads/$image_type", $image_type,CommonUtils::random(6), $width, $height);
        		$vipcasePhoto = new VipCasePhoto();
        		$vipcasePhoto->img_url = $galleryFiles['img_url'];
        		$vipcasePhoto->img_original = $galleryFiles['img_original'];
        		$vipcasePhoto->thumb_url = $galleryFiles['thumb_url'];
        		$vipCasePhotos[] = $vipcasePhoto;
        	}
        	
        	//开始保存事务
        	$transaction = VipCase::getDb()->beginTransaction();
        	try {
        		/* 保存失败处理 */
        		if(!($model->save())){
        			$transaction->rollBack();
        			return $this->renderCreate();
        		}
        		
        		//重命名图片地址
        		if($files){
        				$new_img_original =  $imageUtils->renameImage($model->cover_img_original, $model->id, $image_type);
        				$new_thumb_url = $imageUtils->renameImage($model->cover_thumb_url, $model->id, $image_type, Constant::thumb_flag);
        				$new_img_url = $imageUtils->renameImage($model->cover_img_url, $model->id, $image_type, Constant::img_flag);
        				if($new_img_original){
        					$model->cover_img_original = $new_img_original;
        				}
        				if($new_thumb_url){
        					$model->cover_thumb_url = $new_thumb_url;
        				}
        				if($new_img_url){
        					$model->cover_img_url = $new_img_url;
        				}
        		}
        		
        		if(!($model->save(true,['cover_img_original','cover_thumb_url', 'cover_img_url']))){
        				$model->addError('imageFile','重命名文件失败');
        				$transaction->rollBack();
        				return $this->renderCreate();
        		}
        		
        		
        		//插入相册信息
        		if(!empty($vipCasePhotos)){
        			foreach ($vipCasePhotos as $vipCasePhoto) {
        				$vipCasePhoto->case_id = $model->id;
        				if(!($vipCasePhoto->save())){
        					//         					var_dump($vipCasePhoto);
        					$model->addError('imageFiles','案例相册上传失败');
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
        	
        }

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             MsgUtils::success();
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
			return $this->renderCreate($model);
            /* return $this->render('create', [
                'model' => $model,
            		'vipCaseTypeList' => $this->findVipCaseTypeList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            		'caseFlagList' => SysParameterType::getSysParametersById(SysParameterType::CASE_FLAG),
            		'vipList' => $this->findVipList(),
            		'sysUserList' => $this->findSysUserList(),
            ]); */
//         }
    }
    
    
    /**
     * @return Ambigous <string, string>
     */
    protected function renderCreate($model){
    	return $this->render('create', [
                'model' => $model,
            		'vipCaseTypeList' => $this->findVipCaseTypeList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            		'caseFlagList' => SysParameterType::getSysParametersById(SysParameterType::CASE_FLAG),
            		'vipList' => $this->findVipList(),
            		'sysUserList' => $this->findSysUserList(),
            ]);
    }

    /**
     * Updates an existing VipCase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) {
        	
        	//获取案例封面信息
        	$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        	
        	$imageUtils = new ImageUtils();
        	$image_type = 'vip_case';
        	$width = SysConfig::getInstance()->getConfigVal("thumb_width");
        	$height = SysConfig::getInstance()->getConfigVal("thumb_height");
        	
        	//旧图片地址
        	$old_img_url = $model->cover_img_url;
        	$old_img_original = $model->cover_img_original;
        	$old_thumb_url = $model->cover_thumb_url;
        	
        	if($files = ($imageUtils->uploadImage($model->imageFile, "uploads/$image_type", $image_type, $model->id, $width, $height))){
        		//新图片地址
        		$model->cover_img_url = $files['img_url'];
        		$model->cover_img_original = $files['img_original'];
        		$model->cover_thumb_url = $files['thumb_url'];
        	}
        	
        	//处理案例相册
        	$model->imageFiles = UploadedFile::getInstances($model, "imageFiles");
        	$vipCasePhotos = [];
        	foreach ($model->imageFiles as $galleryFile) {
	        	 $galleryFiles = $imageUtils->uploadImage($galleryFile, "uploads/$image_type", $image_type,CommonUtils::random(6), $width, $height);
	        	 $vipcasePhoto = new VipCasePhoto();
	        	 $vipcasePhoto->img_url = $galleryFiles['img_url'];
	        	 $vipcasePhoto->img_original = $galleryFiles['img_original'];
	        	 $vipcasePhoto->thumb_url = $galleryFiles['thumb_url'];
	        	 $vipCasePhotos[] = $vipcasePhoto;
        	 }
        	
        	$transaction = VipCase::getDb()->beginTransaction();
        	try {
        		if(!($model->save())){
        			$transaction->rollBack();
        			return $this->renderUpdate();
        		}
        		
        		if($files){
        			//删除旧图片
        			if(file_exists($old_img_url)){
        				unlink($old_img_url);
        			}
        			if(file_exists($old_img_original)){
        				unlink($old_img_original);
        			}
        			if(file_exists($old_thumb_url)){
        				unlink($old_thumb_url);
        			}
        		}
        		
//         			MsgUtils::success();
//         			return $this->redirect(['view', 'id' => $model->id]);
        		
        		//插入相册信息
        		if(!empty($vipCasePhotos)){
        			foreach ($vipCasePhotos as $vipCasePhoto) {
        				$vipCasePhoto->case_id = $model->id;
        				if(!($vipCasePhoto->save())){
//         					var_dump($vipCasePhoto);
        					$model->addError('imageFiles','案例相册上传失败');
        					$transaction->rollBack();
        					return $this->renderUpdate();
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
        	
        }

//         if ($model->load(Yii::$app->request->post()) /* && $model->save() */) {
//         	MsgUtils::success();
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {

        	return $this->renderUpdate($model);
        	
            /* return $this->render('update', [
                'model' => $model,
            		'vipCaseTypeList' => $this->findVipCaseTypeList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            		'caseFlagList' => SysParameterType::getSysParametersById(SysParameterType::CASE_FLAG),
            		'vipList' => $this->findVipList(),
            		'sysUserList' => $this->findSysUserList(),
            ]); */
//         }
    }
    
    /**
     * @return Ambigous <string, string>
     */
    protected function renderUpdate($model){
    	return $this->render('update', [
    			'model' => $model,
    			'vipCaseTypeList' => $this->findVipCaseTypeList(),
    			'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
    			'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
    			'caseFlagList' => SysParameterType::getSysParametersById(SysParameterType::CASE_FLAG),
    			'vipList' => $this->findVipList(),
    			'sysUserList' => $this->findSysUserList(),
    	]);
    }
    
    

    /**
     * Deletes an existing VipCase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$model = $this->findModel($id);
    	
    	//TODO: 权限判断
    	$vip_id = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
    	if($model->vip_id != $vip_id){
    		MsgUtils::error("非法操作！");
    		return $this->redirect(['index']);
    	}
    	
    	//开始事务
    	$transaction = VipCase::getDb()->beginTransaction();
    	try{
    		//删除图片
    		$vipCasePhotos = VipCasePhoto::find()->where(['case_id' => $id])->all();
    		foreach ($vipCasePhotos as $vipCasePhoto) {
    			$thumb_url = iconv("UTF-8", "GBK", $vipCasePhoto->thumb_url);
    			$img_original = iconv("UTF-8", "GBK", $vipCasePhoto->img_original);
    			$img_url = iconv("UTF-8", "GBK", $vipCasePhoto->img_url);
    			 
    			if(is_file($thumb_url)){
    				unlink($thumb_url);
    			}
    			if(file_exists($img_original)){
    				unlink($img_original);
    			}
    			if(file_exists($img_url)){
    				unlink($img_url);
    			}
    			$vipCasePhoto->delete();
    		}
    		 
    		//删除文字内容
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
    public function actionDeleteVipCasePhoto($id){
    	$vipCasePhoto = VipCasePhoto::findOne($id);
    	if(empty($vipCasePhoto)){
    		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
    	$vipCasePhoto->delete();
    	
    	$thumb_url = iconv("UTF-8", "GBK", $vipCasePhoto->thumb_url);
    	$img_original = iconv("UTF-8", "GBK", $vipCasePhoto->img_original);
    	$img_url = iconv("UTF-8", "GBK", $vipCasePhoto->img_url);
    	 
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
    	return $this->redirect(['view','id'=>$vipCasePhoto->case_id]);
    }
    
    
    /**
     * submit Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSubmit($id)
    {
    	$vip_id = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
    	$model =  $this->findModel($id);
    	$vip = Vip::findOne($vip_id);
    	if($vip->audit_status!=SysParameter::audit_approved){
    		MsgUtils::warning("营业信息审核通过后，才能提交！");
    		return $this->redirect(['view', 'id' => $model->id]);
    	}
    	
    	//修改案例状态-待审核
    	$model->audit_status = SysParameter::audit_need_approve;
    	$model->save();
    	MsgUtils::success();
    	return $this->render('view', [
    			'model' => $model,
    	]);
//     	return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Finds the VipCase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VipCase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = VipCase::find()->alias('case')
    	->joinWith('auditUser auditUser')
        ->joinWith('auditStatus auditStatus')
        ->joinWith('type type')
        ->joinWith('caseFlag caseFlag')
        ->joinWith('status0 stat')
        ->joinWith('status0 isHot')
        ->joinWith('vip vip')
    	->where(['case.id' => $id])->one();
    	if($model !==null){
//     	if (($model = VipCase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipCaseTypeList(){
    	return VipCaseType::find()->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findVipCaseTypeByVipTypeId($vip_type_id)
    {
    	$model = VipCaseType::find()
    	->where(['vip_type_id'=>$vip_type_id])->one();
    	return $model;
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipList(){
    	return Vip::find()->where(['merchant_flag' => SysParameter::yes])->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findSysUserList(){
    	return SysUser::find()->all();
    }
    
    
}
