<?php

namespace app\modules\admin\controllers\basic;

use Yii;
use app\models\b2b2c\Activity;
use app\models\b2b2c\search\ActivitySearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\ActivityType;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;
use yii\web\UploadedFile;
use app\common\utils\image\ImageUtils;
use app\models\b2b2c\SysConfig;
use app\modules\admin\models\AdminConst;
use app\models\b2b2c\common\Constant;
use app\models\b2b2c\ActPackageProduct;
use app\models\b2b2c\Product;

/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends BaseAuthController
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
     * Lists all Activity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActivitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'activityTypeList' => $this->findActivityTypeList(),
        		'vipList' => $this->findVipList(),
        		'sysUserList' => $this->findSysUserList(),
        		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
        		'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
        ]);
    }

    /**
     * Displays a single Activity model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model =  $this->findModel($id);
        $actPackageProducts = $this->findActPackageProductList($id);
    	
    	return $this->render('view', [
            'model' => $model,
    		'actPackageProducts' => $actPackageProducts,
        ]);
    }

    /**
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Activity();
        $model->activity_type = 1;//优惠套装
        $model->start_time=date(AdminConst::DATE_FORMAT,time());
        $model->end_date= date(AdminConst::DATE_FORMAT,time());
        

        if ($model->load(Yii::$app->request->post())/*  && $model->save() */) {
        	
        	$model->imageFile = UploadedFile::getInstance($model, "imageFile");
        	
        	//处理图片
        	$imageUtils = new ImageUtils();
        	$image_type = 'activity';
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
            		'activityTypeList' => $this->findActivityTypeList(),
            		'vipList' => $this->findVipList(),
            		'sysUserList' => $this->findSysUserList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            ]);
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())/*  && $model->save() */) {
        //获取图片信息
        	$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        	 
        	$imageUtils = new ImageUtils();
        	$image_type = 'activity';
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
            		'activityTypeList' => $this->findActivityTypeList(),
            		'vipList' => $this->findVipList(),
            		'sysUserList' => $this->findSysUserList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            ]);
       
    }

    /**
     * Deletes an existing Activity model.
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
     * 添加团队成员
     * @return \yii\web\Response|Ambigous <string, string>
     */
    public function actionCreateActPackageProduct($act_id){    	
    	$model = new ActPackageProduct();
    	$model->act_id = $act_id;
    	$model->quantity = 1;
    	
    	$count = ActPackageProduct::find()->where(['act_id'=>$act_id, 'product_id' => 1])->count();
    	
    	//查询活动
    	$activity = Activity::findOne($act_id);
    	if(empty($activity)){
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    	
    	if ($model->load(Yii::$app->request->post())) {
    		//检查团队成员是否已经存在，不能重复添加 TODO:
    		$count = ActPackageProduct::find()->where(['act_id'=>$act_id, 'product_id' => $model->product_id])->count();
    		if($count>=1){
    			$model->addError("product_id","该个人服务已经存在！"); 			
    			return $this->render('create-act-package-product', [
    					'model' => $model,
    					'activity' => $activity,
    					//'activityList' => $this->findActivityList(),
    					'productList' => $this->findProductList(),
    			]);
    		}
    		
    		
    		if($model->save()){
    			MsgUtils::success();
    			return $this->redirect(['view', 'id' => $act_id]);
    		}
    		
    		
    	} /* else { */
    		return $this->render('create-act-package-product', [
    				'model' => $model,
    				'activity' => $activity,
    				//'activityList' => $this->findActivityList(),
    				'productList' => $this->findProductList(),
    		]);
    	/* } */
    }
    
    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDeleteActPackageProduct($id)
    {
    	$actPackageProduct = ActPackageProduct::findOne($id);
    	if(empty($actPackageProduct)){
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    	$actPackageProduct->delete();
    	MsgUtils::success();
    	return $this->redirect(['view','id'=>$actPackageProduct->act_id]);
    }

    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = Activity::find()->alias('act')
    	->joinWith('activityType activityType')
    	->joinWith('vip vip')
    	->joinWith('auditStatus auditStatus')
    	->joinWith('auditUser auditUser')
    	->joinWith('actScopes actScopes')
    	->where(['act.id' => $id])->one();
    	if($model !==null){
//     	if (($model = Activity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    function findActPackageProductList($act_id){
    	$models = ActPackageProduct::find()->alias('actProd')
    		->joinWith('act act')
    		->joinWith('product.vip vip')
    		->where(['actProd.act_id' => $act_id])->all();
    	return $models;
    }
    
    /**
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findActivityTypeList(){
    	return ActivityType::find()->all();
    }
    
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipList(){
    	return Vip::find()->where(['merchant_flag'=>SysParameter::yes])->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findSysUserList(){
    	return SysUser::find()->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findProductList(){
    	return Product::find()->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findProductMerchantList(){
    	return Product::find()->select(['p.*','vip.vip_id','vip.vip_name'])->alias("p")->joinWith("vip vip")->where(["p.service_flag"=>SysParameter::yes])->all();
    }
}
