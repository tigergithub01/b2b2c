<?php

namespace app\modules\admin\controllers\vip;

use Yii;
use app\models\b2b2c\VipConcern;
use app\models\b2b2c\search\VipConcernSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;

/**
 * VipConcernController implements the CRUD actions for VipConcern model.
 */
class VipConcernController extends BaseAuthController
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
     * Lists all VipConcern models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipConcernSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'vipList' => $this->findVipList(SysParameter::no),
        	'merchantList' => $this->findVipList(SysParameter::yes),
        ]);
    }

    /**
     * Displays a single VipConcern model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        	'vipList' => $this->findVipList(SysParameter::no),
            'merchantList' => $this->findVipList(SysParameter::yes),
        ]);
    }

    /**
     * Creates a new VipConcern model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VipConcern();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            	'vipList' => $this->findVipList(SysParameter::no),
            	'merchantList' => $this->findVipList(SysParameter::yes),
            ]);
        }
    }

    /**
     * Updates an existing VipConcern model.
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
            	'vipList' => $this->findVipList(),
            ]);
        }
    }

    /**
     * Deletes an existing VipConcern model.
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
     * Finds the VipConcern model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VipConcern the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = VipConcern::find()->alias('vipConcern')
    	->joinWith('vip vip')
    	->joinWith('refVip refVip')
    	->where(['vipConcern.id' => $id])->one();
    	if($model !==null){
        // if (($model = VipConcern::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipList($merchant_flag){
    	return Vip::find()->where(['merchant_flag'=>$merchant_flag])->all();
    }
    
}
