<?php

namespace app\modules\admin\controllers\basic;

use Yii;
use app\models\b2b2c\ActPackageProduct;
use app\models\b2b2c\search\ActPackageProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\Activity;
use app\models\b2b2c\Product;

/**
 * ActPackageProductController implements the CRUD actions for ActPackageProduct model.
 */
class ActPackageProductController extends Controller
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
     * Lists all ActPackageProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActPackageProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'activityList' => $this->findActivityList(),
        		'productList' => $this->findProductList(),
        ]);
    }

    /**
     * Displays a single ActPackageProduct model.
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
     * Creates a new ActPackageProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ActPackageProduct();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            	'activityList' => $this->findActivityList(),
            	'productList' => $this->findProductList(),
            ]);
        }
    }

    /**
     * Updates an existing ActPackageProduct model.
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
            		'activityList' => $this->findActivityList(),
            		'productList' => $this->findProductList(),
            ]);
        }
    }

    /**
     * Deletes an existing ActPackageProduct model.
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
     * Finds the ActPackageProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ActPackageProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	protected function findModel($id)
    {
    	$model = ActPackageProduct::find()->alias('actProd')
    	->joinWith('act act')
    	->joinWith('product product')
    	->where(['actProd.id' => $id])->one();
    	
    	if($model !==null){
//         if (($model = ActPackageProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findActivityList(){
    	return Activity::find()->all();
    }
    
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findProductList(){
    	return Product::find()->all();
    }
}
