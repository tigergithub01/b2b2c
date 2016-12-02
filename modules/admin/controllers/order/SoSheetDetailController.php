<?php

namespace app\modules\admin\controllers\order;

use app\common\utils\MsgUtils;
use app\models\b2b2c\Activity;
use app\models\b2b2c\Product;
use app\models\b2b2c\search\SoSheetDetailSearch;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\SoSheetDetail;
use app\modules\admin\common\controllers\BaseAuthController;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * SoSheetDetailController implements the CRUD actions for SoSheetDetail model.
 */
class SoSheetDetailController extends BaseAuthController
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
     * Lists all SoSheetDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SoSheetDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'activityList' => $this->findActivityList(),
        		'productList' => $this->findProductList(),
        		'soSheetList' => $this->findSoSheetList(),
        ]);
    }

    /**
     * Displays a single SoSheetDetail model.
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
     * Creates a new SoSheetDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SoSheetDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            		'activityList' => $this->findActivityList(),
            		'productList' => $this->findProductList(),
            		'soSheetList' => $this->findSoSheetList(),
            ]);
        }
    }

    /**
     * Updates an existing SoSheetDetail model.
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
            		'soSheetList' => $this->findSoSheetList(),
            ]);
        }
    }

    /**
     * Deletes an existing SoSheetDetail model.
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
     * Finds the SoSheetDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SoSheetDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = SoSheetDetail::find()->alias('soDetail')
    	->joinWith('order order')
    	->joinWith('package package')
    	->joinWith('product product')
    	->where(['soDetail.id' => $id])->one();
    	 
    	if($model !==null){
//         if (($model = SoSheetDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    /**
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findActivityList(){
    	return Activity::find()->all();
    }
    
    /**
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findSoSheetList(){
    	return SoSheet::find()->all();
    }
    
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findProductList(){
    	return Product::find()->all();
    }
}
