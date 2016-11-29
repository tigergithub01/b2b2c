<?php

namespace app\modules\admin\controllers\vip;

use app\common\utils\MsgUtils;
use app\models\b2b2c\Activity;
use app\models\b2b2c\Product;
use app\models\b2b2c\search\VipCollectSearch;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\Vip;
use app\models\b2b2c\VipCase;
use app\models\b2b2c\VipCollect;
use app\modules\admin\common\controllers\BaseAuthController;
use Yii;
use yii\web\NotFoundHttpException;
use app\models\b2b2c\SysParameterType;

/**
 * VipCollectController implements the CRUD actions for VipCollect model.
 */
class VipCollectController extends BaseAuthController
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
     * Lists all VipCollect models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipCollectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'vipList' => $this->findVipList(SysParameter::no),
        		'merchantList' => $this->findVipList(SysParameter::yes),
        		'productList' => $this->findProductList(),
        		'vipCaseList' => $this->findVipCaseList(),
        		'activityList' => $this->findActivityList(),
        		'collectTypeList' => SysParameterType::getSysParametersById(SysParameterType::VIP_COLLECT_TYPE),
        ]);
    }

    /**
     * Displays a single VipCollect model.
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
     * Creates a new VipCollect model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VipCollect();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            		'vipList' => $this->findVipList(SysParameter::no),
            		'merchantList' => $this->findVipList(SysParameter::yes),
            		'productList' => $this->findProductList(),
            		'vipCaseList' => $this->findVipCaseList(),
            		'activityList' => $this->findActivityList(),
            		'collectTypeList' => SysParameterType::getSysParametersById(SysParameterType::VIP_COLLECT_TYPE),
            ]);
        }
    }

    /**
     * Updates an existing VipCollect model.
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
            	'vipList' => $this->findVipList(SysParameter::no),
            	'merchantList' => $this->findVipList(SysParameter::yes),
            	'productList' => $this->findProductList(),
            	'vipCaseList' => $this->findVipCaseList(),
            	'activityList' => $this->findActivityList(),
            	'collectTypeList' => SysParameterType::getSysParametersById(SysParameterType::VIP_COLLECT_TYPE),
            ]);
        }
    }

    /**
     * Deletes an existing VipCollect model.
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
     * Finds the VipCollect model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VipCollect the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = VipCollect::find()->alias('vipCollect')
    	->joinWith('vip vip')
    	->joinWith('package package')
    	->joinWith('case case')
    	->joinWith('product product')
    	->joinWith('collectType collectType')
    	->joinWith('refVip refVip')
    	->where(['vipCollect.id' => $id])->one();
    	if($model !==null){
//     	if (($model = VipCollect::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
	protected  function findVipList($merchant_flag){
    	return Vip::find()->where(['merchant_flag'=>$merchant_flag])->all();
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
    protected  function findActivityList(){
    	return Activity::find()->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipCaseList(){
    	return VipCase::find()->all();
    }
}
