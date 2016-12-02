<?php

namespace app\modules\merchant\controllers\basic;

use Yii;
use app\models\b2b2c\Product;
use app\models\b2b2c\search\ProductSearch;
use app\modules\merchant\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\ProductType;
use app\models\b2b2c\ProductBrand;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;
use app\modules\merchant\controllers\vip\MerchantController;
use app\models\b2b2c\VipProductType;
use app\modules\merchant\models\MerchantConst;

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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            	'ptypeList' => $this->findPtypeList(),
            	'pbrandList' => $this->findPbrandList(),
            	'vipList' => $this->findVipList(),
            	'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'pStatusList' => SysParameterType::getSysParametersById(SysParameterType::PRODUCT_STATUS),
            	'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            ]);
        }
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
        
        $vip_id = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
        $model->vip_id = $vip_id;
        $model->service_flag = SysParameter::yes;
        $model->is_on_sale = Product::is_on_sale_yes;
        $model->is_hot = SysParameter::yes;
        $model->audit_status = SysParameter::audit_approved;
        $model->can_return_flag = SysParameter::yes;
        $model->is_free_shipping = SysParameter::no;
        
        $vip = Vip::findOne($vip_id);
        $model->name = $vip->vip_name;
        $vipProductType = $this->findProductTypeByVipTypeId($vip->vip_type_id);
        if($vipProductType){
        	$model->type_id= $vipProductType->product_type_id;
        }
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            		'ptypeList' => $this->findPtypeList(),
            		'pbrandList' => $this->findPbrandList(),
            		'vipList' => $this->findVipList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'pStatusList' => SysParameterType::getSysParametersById(SysParameterType::PRODUCT_STATUS),
            		'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            ]);
        }
    }
    
    
    /***
     *  更新个人服务与定价
     */
    public function actionUpdateService(){
    	
    	$vip_id = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
    	$model = $this->findProduct($vip_id);
    	$model->vip_id = $vip_id;
    	$model->service_flag = SysParameter::yes;
    	$model->is_on_sale = Product::is_on_sale_yes;
    	$model->is_hot = SysParameter::yes;
    	$model->audit_status = SysParameter::audit_approved;
    	$model->can_return_flag = SysParameter::yes;
    	$model->is_free_shipping = SysParameter::no;
    	
    	$vip = Vip::findOne($vip_id);
    	$model->name = $vip->vip_name;
    	$vipProductType = $this->findProductTypeByVipTypeId($vip->vip_type_id);
    	if($vipProductType){
    		$model->type_id= $vipProductType->product_type_id;
    	}
    	
    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		MsgUtils::success();
    		return $this->render('update-service', [
    				'model' => $model,
    		]);
    		//return $this->redirect(['view', 'id' => $model->id]);
    	} else {
    		return $this->render('update-service', [
    				'model' => $model,
    		]);
    	}
    }

    /**
     * Deletes an existing Product model.
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
    
    
}
