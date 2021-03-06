<?php

namespace app\modules\vip\controllers\basic;

use Yii;
use app\models\b2b2c\Product;
use app\models\b2b2c\search\ProductSearch;
use app\modules\vip\common\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\ProductType;
use app\models\b2b2c\ProductBrand;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BaseController
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
    
    
}
