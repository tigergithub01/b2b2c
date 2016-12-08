<?php

namespace app\modules\admin\controllers\vip;

use app\common\utils\CommonUtils;
use app\common\utils\image\ImageUtils;
use app\common\utils\MsgUtils;
use app\models\b2b2c\common\Constant;
use app\models\b2b2c\Product;
use app\models\b2b2c\search\VipSearch;
use app\models\b2b2c\SysConfig;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\SysRegion;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\Vip;
use app\models\b2b2c\VipExtend;
use app\models\b2b2c\VipOrganization;
use app\models\b2b2c\VipProductType;
use app\models\b2b2c\VipRank;
use app\models\b2b2c\VipType;
use app\modules\admin\common\controllers\BaseAuthController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\common\utils\DateUtils;
use app\modules\admin\models\AdminConst;

/**
 * VipController implements the CRUD actions for Vip model.
 */
class MerchantController extends BaseAuthController
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
     * Lists all Vip models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipSearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['VipSearch']['merchant_flag'] = SysParameter::yes;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'vipRankList' => $this->findVipRankList(),
            	'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            	'vipTypeList' => $this->findVipTypeList(),
            	'sexList' => SysParameterType::getSysParametersById(SysParameterType::VIP_SEX),
        ]);
    }

    /**
     * Displays a single Vip model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);
    	$vipOrganization = $this->findVipOrganization($model->id);
    	$vipExtend = $this->findVipExtend($model->id);
    	$product = $this->findProduct($model->id);
    	
    	return $this->render('view', [
            'model' => $model,
    		'vipOrganization' => $vipOrganization,
    		'vipExtend' => $vipExtend,
    		'product' => $product,
        ]);
    }

    /**
     * Creates a new Vip model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vip();
        $model->merchant_flag = SysParameter::yes;
        $model->mobile_verify_flag = SysParameter::yes;
        $model->email_verify_flag = SysParameter::no;
        $model->status = SysParameter::yes;
        $model->audit_status = SysParameter::audit_need_approve;
        $model->register_date = \app\common\utils\DateUtils::formatDatetime();
        
        $vipOrganization= new VipOrganization();
        $vipExtend= new VipExtend();
        $product = new Product();

        if ($model->load(Yii::$app->request->post())/*  && $model->save() */) {
        	//加密
        	$model->password = md5($model->password);
        	
        	$model->imageFile = UploadedFile::getInstance($model, "imageFile");
        	
        	//处理图片
        	$imageUtils = new ImageUtils();
        	$image_type = 'merchant';
        	$width = SysConfig::getInstance()->getConfigVal("thumb_width");
        	$height = SysConfig::getInstance()->getConfigVal("thumb_height");
        	
        	if($files = ($imageUtils->uploadImage($model->imageFile, "uploads/$image_type", $image_type,null, $width, $height))){
        		$model->img_url = $files['img_url'];
        		$model->img_original = $files['img_original'];
        		$model->thumb_url = $files['thumb_url'];
        	}
        	 
        	if($model->save()){
        		//重命名图片地址
        		if($files){
        			$new_img_original =  $imageUtils->renameImage($model->img_original, $model->id, $image_type);
        			$new_thumb_url = $imageUtils->renameImage($model->thumb_url, $model->id, $image_type, Constant::thumb_flag);
        			$new_img_url = $imageUtils->renameImage($model->img_url, $model->id, $image_type, Constant::img_flag);
        			if($new_img_original){
        				$model->img_original = $new_img_original;
        			}
        			if($new_thumb_url){
        				$model->thumb_url = $new_thumb_url;
        			}
        			if($new_img_url){
        				$model->img_url = $new_img_url;
        			}
        		}
        	
        		if($model->save(true,['img_original','thumb_url', 'img_url'])){
        			MsgUtils::success();
        			return $this->redirect(['view', 'id' => $model->id]);
        		}
        	}
           
        }
        
       return $this->render('create', [
                'model' => $model,
       			'vipOrganization' => $vipOrganization,
       			'vipExtend' => $vipExtend,
       			'product' => $product,
            	'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'vipRankList' => $this->findVipRankList(),
            	'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            	'vipTypeList' => $this->findVipTypeList(),
            	'sexList' => SysParameterType::getSysParametersById(SysParameterType::VIP_SEX),
            	'userList' => $this->findSysUserList(),	
	       		'proviceList' => null,
	       		'cityList' => null,
	       		'districtList' => null,
	       		'countryList' => $this->findSysRegionList(SysRegion::region_type_country),
            ]);
    }

    /**
     * Updates an existing Vip model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $vipOrganization = $this->findVipOrganization($model->id);
        if(empty($vipOrganization)){
        	$vipOrganization= new VipOrganization();
        	$vipOrganization->vip_id = $model->id;
        	$vipOrganization->status = SysParameter::yes;
        	$vipOrganization->create_date = \app\common\utils\DateUtils::formatDatetime();
        	$vipOrganization->update_date = \app\common\utils\DateUtils::formatDatetime();
        	$vipOrganization->audit_status = SysParameter::audit_approved;
        }
        $vipExtend = $this->findVipExtend($model->id);
        if(empty($vipExtend)){
        	$vipExtend= new VipExtend();
        	$vipExtend->vip_id = $model->id;
        	$vipExtend->audit_status = SysParameter::audit_approved;
        	$vipExtend->create_date = \app\common\utils\DateUtils::formatDatetime();
        	$vipExtend->update_date = \app\common\utils\DateUtils::formatDatetime();
        }
        $product = $this->findProduct($model->id);
        if(empty($product)){
        	$product= new Product();
        	$product->vip_id = $model->id;
        	$product->service_flag = SysParameter::yes;
        	$product->is_on_sale = SysParameter::yes;
        	$product->is_hot = SysParameter::yes;
        	$product->audit_status = SysParameter::audit_approved;
        	$product->can_return_flag = SysParameter::yes;
        	$product->is_free_shipping = SysParameter::no;
        }

        if ($model->load(Yii::$app->request->post())  && $vipOrganization->load(Yii::$app->request->post()) && $vipExtend->load(Yii::$app->request->post()) && $product->load(Yii::$app->request->post())) {
        	
        	/** 基础信息图片 */
        	//获取LOGO图片信息
        	$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        	$imageUtils = new ImageUtils();
        	$image_type = 'merchant';
        	$width = SysConfig::getInstance()->getConfigVal("thumb_width");
        	$height = SysConfig::getInstance()->getConfigVal("thumb_height");
        	 
        	//旧LOGO图片地址
        	$old_img_url = $model->img_url;
        	$old_img_original = $model->img_original;
        	$old_thumb_url = $model->thumb_url;
        	 
        	if($files = ($imageUtils->uploadImage($model->imageFile, "uploads/$image_type", $image_type, $model->id, $width, $height))){
        		//新图片地址
        		$model->img_url = $files['img_url'];
        		$model->img_original = $files['img_original'];
        		$model->thumb_url = $files['thumb_url'];
        	}
        	
        	/** 营业信息图片 */
        	//获取商户封面信息
        	$vipOrganization->imageFilecover = UploadedFile::getInstance($vipOrganization, 'imageFilecover');
        	$imageUtils = new ImageUtils();
        	$image_type = 'merchant';
        	$width = SysConfig::getInstance()->getConfigVal("thumb_width");
        	$height = SysConfig::getInstance()->getConfigVal("thumb_height");
        	 
        	//旧商户封面图片地址
        	$old_cover_img_url = $vipOrganization->cover_img_url;
        	$old_cover_img_original = $vipOrganization->cover_img_original;
        	$old_cover_thumb_url = $vipOrganization->cover_thumb_url;   	  

        	if($files_cover = ($imageUtils->uploadImage($vipOrganization->imageFilecover, "uploads/$image_type", $image_type, CommonUtils::random(6,1), $width, $height))){
        		//新图片地址
        		$vipOrganization->cover_img_url = $files_cover['img_url'];
        		$vipOrganization->cover_img_original = $files_cover['img_original'];
        		$vipOrganization->cover_thumb_url = $files_cover['thumb_url'];
        	}
        	
        	/** 个人信息图片 */
        	//1、获取个人身份证正面照信息
        	$vipExtend->imageFileIdCard = UploadedFile::getInstance($vipExtend, 'imageFileIdCard');
        	$imageUtils = new ImageUtils();
        	$image_type = 'merchant';
        	$width = SysConfig::getInstance()->getConfigVal("thumb_width");
        	$height = SysConfig::getInstance()->getConfigVal("thumb_height");
        	
        	//旧个人身份证正面照图片地址
        	$old_id_card_img_url = $vipExtend->id_card_img_url;
        	$old_id_card_img_original = $vipExtend->id_card_img_original;
        	$old_id_card_thumb_url = $vipExtend->id_card_thumb_url;
        	
        	if($files_id_card = ($imageUtils->uploadImage($vipExtend->imageFileIdCard, "uploads/$image_type", $image_type, CommonUtils::random(6,1), $width, $height))){
        		//新图片地址
        		$vipExtend->id_card_img_url = $files_id_card['img_url'];
        		$vipExtend->id_card_img_original = $files_id_card['img_original'];
        		$vipExtend->id_card_thumb_url = $files_id_card['thumb_url'];
        	}
        	
        	//2、获取个人身份证背面照信息
        	$vipExtend->imageFileIdCardBack = UploadedFile::getInstance($vipExtend, 'imageFileIdCardBack');
        	$imageUtils = new ImageUtils();
        	$image_type = 'merchant';
        	$width = SysConfig::getInstance()->getConfigVal("thumb_width");
        	$height = SysConfig::getInstance()->getConfigVal("thumb_height");
        	 
        	//旧个人身份证背面照图片地址
        	$old_id_back_img_url = $vipExtend->id_back_img_url;
        	$old_id_back_img_original = $vipExtend->id_back_img_original;
        	$old_id_back_thumb_url = $vipExtend->id_back_thumb_url;
        	 
        	if($files_id_card_back = ($imageUtils->uploadImage($vipExtend->imageFileIdCardBack, "uploads/$image_type", $image_type, CommonUtils::random(6,1), $width, $height))){
        		//新图片地址
        		$vipExtend->id_back_img_url = $files_id_card_back['img_url'];
        		$vipExtend->id_back_img_original = $files_id_card_back['img_original'];
        		$vipExtend->id_back_thumb_url = $files_id_card_back['thumb_url'];
        	}
        	
        	
        	//更新服务名称和商户名称相同
        	$product->name = $model->vip_name;
        	$vipProductType = $this->findProductTypeByVipTypeId($model->vip_type_id);
        	if($vipProductType){
        		$product->type_id= $vipProductType->product_type_id;
        	}
        	
        	//保存数据
        	if($model->save() && $vipOrganization->save() && $vipExtend->save() && $product->save()){
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
        		
        		if($files_cover){
        			//删除旧封面图片
        			if(file_exists($old_cover_img_url)){
        				unlink($old_cover_img_url);
        			}
        			if(file_exists($old_cover_img_original)){
        				unlink($old_cover_img_original);
        			}
        			if(file_exists($old_cover_thumb_url)){
        				unlink($old_cover_thumb_url);
        			}
        		}
        		
        		if($files_id_card){
        			//删除旧身份证正面照
        			if(file_exists($old_id_card_img_url)){
        				unlink($old_id_card_img_url);
        			}
        			if(file_exists($old_id_card_img_original)){
        				unlink($old_id_card_img_original);
        			}
        			if(file_exists($old_id_card_thumb_url)){
        				unlink($old_id_card_thumb_url);
        			}
        		}
        		
        		if($files_id_card_back){
        			//删除旧身份证背面照
        			if(file_exists($old_id_back_img_url)){
        				unlink($old_id_back_img_url);
        			}
        			if(file_exists($old_id_back_img_original)){
        				unlink($old_id_back_img_original);
        			}
        			if(file_exists($old_id_back_thumb_url)){
        				unlink($old_id_back_thumb_url);
        			}
        		}
        		
        		MsgUtils::success();
        		return $this->redirect(['view', 'id' => $model->id]);
        	}
        }/*  else { */
            return $this->render('update', [
                	'model' => $model,
            		'vipOrganization' => $vipOrganization,
            		'vipExtend' => $vipExtend,
            		'product' => $product,
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'vipRankList' => $this->findVipRankList(),
            		'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            		'vipTypeList' => $this->findVipTypeList(),
            		'sexList' => SysParameterType::getSysParametersById(SysParameterType::VIP_SEX),
            		'userList' => $this->findSysUserList(),
            		'proviceList' => $this->findSysRegionList(SysRegion::region_type_province, $vipOrganization->country_id),
            		'cityList' => $this->findSysRegionList(SysRegion::region_type_city, $vipOrganization->province_id),
            		'districtList' => $this->findSysRegionList(SysRegion::region_type_district, $vipOrganization->city_id),
            		'countryList' => $this->findSysRegionList(SysRegion::region_type_country),
            ]);
        /* } */
    }

    /**
     * Deletes an existing Vip model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		MsgUtils::success();
        return $this->redirect(['index']);
    }
    
    
    /**
     * 同意
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionApprove($id)
    {
    	$model =  $this->findModel($id);
    	$model->audit_status = SysParameter::audit_approved;
    	$model->audit_date = DateUtils::formatDatetime();
    	$model->audit_user_id =  \Yii::$app->session->get(AdminConst::LOGIN_ADMIN_USER)->id;
    	$model->save();
    	MsgUtils::success();
    	return $this->redirect(['view', 'id' => $model->id]);
    }
    
    
    /**
     * 不同意
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionReject($id)
    {
    	$audit_memo = isset($_REQUEST['audit_memo'])?$_REQUEST['audit_memo']:null;
    	$model =  $this->findModel($id);
    	$model->audit_memo = $audit_memo;
    	$model->audit_status = SysParameter::audit_rejected;
    	$model->audit_date = DateUtils::formatDatetime();
    	$model->audit_user_id =  \Yii::$app->session->get(AdminConst::LOGIN_ADMIN_USER)->id;
    	$model->save();
    	MsgUtils::success();
    	return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Finds the Vip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Vip the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = Vip::find()->alias('vip')
    	->joinWith('status0 stat')
    	->joinWith('auditStatus auditStat')
    	->joinWith('auditUser auditStatUsr')
    	->joinWith('emailVerifyFlag emailVerify')
    	->joinWith('parent parent')
    	->joinWith('merchantFlag mercFlag')
    	->joinWith('vipType vType')
    	->joinWith('mobileVerifyFlag mobileVerify')
    	->joinWith('rank rank')
    	->joinWith('sex0 sex')
    	->where(['vip.id'=>$id])->one();
    	if($model){
//     	if (($model = Vip::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    /**
     * findVipOrganization
     * @param unknown $id
     * @return unknown
     */
    protected function findVipOrganization($vip_id)
    {
    	$model = VipOrganization::find()->alias('vipOrg')
    	->joinWith('auditUser auditUser')
    	->joinWith('auditStatus auditStatus')
    	->joinWith('district district')
    	->joinWith('city city')
    	->joinWith('country country')
    	->joinWith('province province')
    	->joinWith('vip vip')
    	->joinWith('status0 stat')
    	->where(['vipOrg.vip_id'=>$vip_id])->one();
    	return $model;
    }
    
    /**
     * findVipExtend
     * @param unknown $id
     * @return unknown
     */
    protected function findVipExtend($vip_id)
    {
    	$model = VipExtend::find()->alias('vipExtend')
    	->joinWith('auditUser auditUser')
    	->joinWith('auditStatus auditStatus')
    	->joinWith('vip vip')
    	->where(['vipExtend.vip_id'=>$vip_id])->one();
    	return $model;
    }
    
    
    /**
     * findProduct
     * @param unknown $id
     * @return unknown
     */
    protected function findProduct($vip_id)
    {
    	$model = Product::find()
    	->where(['vip_id'=>$vip_id, 'service_flag'=>SysParameter::yes])->one();
    	return $model;
    }
    
    /**
     * findProductTypeIdByVipTypeId
     * @param unknown $id
     * @return unknown
     */
    protected function findProductTypeByVipTypeId($vip_type_id)
    {
    	$model = VipProductType::find()
    	->where(['vip_type_id'=>$vip_type_id])->one();
    	return $model;
    }
    
    /**
     * 
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipRankList(){
    	return VipRank::find()->all();
    }
    
   /**
    * 
    */
    protected  function findVipTypeList(){
    	return VipType::find()->where(['merchant_flag'=>SysParameter::yes])->all();
    }
    
    /**
     * 
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findSysUserList(){
    	return SysUser::find()->all();
    }
    
    
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findSysRegionList($region_type, $parent_id = null){
    	return SysRegion::find()
    	->where(['region_type' =>$region_type])
    	->andFilterWhere(['parent_id' => $parent_id])->limit(100)->offset(0)->all();
    }
    
    /**
     *
     * @param unknown $parent_id
     */
    public function actionSubRegionList($id){
    	$models = SysRegion::find()->where(['parent_id' =>$id])->all();
    	return CommonUtils::json_success($models);
    }
    
    
}
