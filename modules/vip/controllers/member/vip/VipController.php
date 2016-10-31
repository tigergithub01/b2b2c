<?php

namespace app\modules\vip\controllers\member\vip;

use Yii;
use app\models\b2b2c\Vip;
use app\models\b2b2c\search\VipSearch;
use app\modules\vip\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\VipRank;
use app\models\b2b2c\VipType;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysUser;
use yii\web\UploadedFile;
use app\common\utils\image\ImageUtils;
use app\models\b2b2c\SysConfig;
use app\models\b2b2c\common\Constant;
use app\models\b2b2c\VipOrganization;
use app\models\b2b2c\VipExtend;
use app\modules\vip\models\VipConst;

/**
 * VipController implements the CRUD actions for Vip model.
 */
class VipController extends BaseAuthController
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vip model.
     * @param string $id
     * @return mixed
     */
    public function actionView()
    {
        $id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
    	
    	return $this->render('view', [
            'model' => $this->findModel($id),
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
        $model->merchant_flag = SysParameter::no;
        $model->mobile_verify_flag = SysParameter::yes;
        $model->email_verify_flag = SysParameter::no;
        $model->status = SysParameter::yes;
        $model->audit_status = SysParameter::audit_approved;
        $model->register_date = date(VipConst::DATE_FORMAT, time());

        if ($model->load(Yii::$app->request->post())/*  && $model->save() */) {
        	//加密
        	$model->password = md5($model->password);
        	$model->imageFile = UploadedFile::getInstance($model, "imageFile");
        	
        	//处理图片
        	$imageUtils = new ImageUtils();
        	$image_type = 'vip';
        	$width = SysConfig::getInstance()->getConfigVal("thumb_width");
        	$height = 0 /* SysConfig::getInstance()->getConfigVal("thumb_height") */;
        	
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
            	'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'vipRankList' => $this->findVipRankList(),
            	'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            	'vipTypeList' => $this->findVipTypeList(),
            	'sexList' => SysParameterType::getSysParametersById(SysParameterType::VIP_SEX),
            	'userList' => $this->findSysUserList(),	
            ]);
    }

    /**
     * Updates an existing Vip model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
    	$id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
        
    	$model = $this->findModel($id);
//         $vipOrganization = $this->findVipOrganization($model->vip_id);
//         $vipExtend = $this->findVipExtend($model->vip_id);
		
        if ($model->load(Yii::$app->request->post())/*  && $vipOrganization->load(Yii::$app->request->post()) && $vipExtend->load(Yii::$app->request->post()) */ ) {
        	
        	//获取图片信息
        	$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        	 
        	$imageUtils = new ImageUtils();
        	$image_type = 'vip';
        	$width = SysConfig::getInstance()->getConfigVal("thumb_width");
        	$height = SysConfig::getInstance()->getConfigVal("thumb_height");
        	 
        	//旧图片地址
        	$old_img_url = $model->img_url;
        	$old_img_original = $model->img_original;
        	$old_thumb_url = $model->thumb_url;
        	
        	
        	if($files = ($imageUtils->uploadImage($model->imageFile, "uploads/$image_type", $image_type, $model->id, $width, $height))){
        		//新图片地址
        		$model->img_url = $files['img_url'];
        		$model->img_original = $files['img_original'];
        		$model->thumb_url = $files['thumb_url'];
        	}
        	
        	if($model->save()){
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
        		MsgUtils::success();
        		return $this->redirect(['view', 'id' => $model->id]);
        	}
        }
        
        return $this->render('update', [
                	'model' => $model,
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'vipRankList' => $this->findVipRankList(),
            		'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            		'vipTypeList' => $this->findVipTypeList(),
            		'sexList' => SysParameterType::getSysParametersById(SysParameterType::VIP_SEX),
            		'userList' => $this->findSysUserList(),
            ]);
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
            throw new NotFoundHttpException('The requested page does not exist.');
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
    	return VipType::find()->where(['merchant_flag'=>SysParameter::no])->all();
    }
    
    /**
     * 
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findSysUserList(){
    	return SysUser::find()->all();
    }
}
