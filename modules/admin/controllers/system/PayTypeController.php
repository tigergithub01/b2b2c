<?php

namespace app\modules\admin\controllers\system;

use Yii;
use app\models\b2b2c\PayType;
use app\models\b2b2c\search\PayTypeSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysParameterType;
use yii\base\Model;
use app\common\utils\MsgUtils;

/**
 * PayTypeController implements the CRUD actions for PayType model.
 */
class PayTypeController extends BaseAuthController
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
     * Lists all PayType models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$searchModel = new PayTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayType model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
//     	Yii::$app->session->setFlash('postDeleted', 'You have successfully deleted your post.');
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PayType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//     	var_dump(Yii::$app->request->absoluteUrl);
    	
        $model = new PayType();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            	'yesNoList'=>$this->getYesNoList(),
            ]);
        }
    }

    /**
     * Updates an existing PayType model.
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
            	'yesNoList'=>$this->getYesNoList(),
            ]);
        }
    }

    /**
     * Deletes an existing PayType model.
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
     * Finds the PayType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PayType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function getYesNoList(){
    	$yesno_list = SysParameter::find()->where("type_id=:type_id",['type_id'=>SysParameterType::YES_NO])->orderBy("seq_id")->all();
//     	$yesno_list = SysParameter::find()->select("id,param_val")->where("type_id=:type_id",['type_id'=>SysParameterType::YES_NO])->orderBy("seq_id")->all();
    	//         	$yesno_list = SysParameter::find()->where("type_id=:type_id",['type_id'=>SysParameterType::YES_NO])->orderBy('seq_id ASC')->all();
    	//         $yesno_list = SysParameter::findBySql("select id,param_val from t_sys_parameter where type_id=:type_id",['type_id'=>SysParameterType::YES_NO])->all();
//     	        $yesno_list = (new \yii\db\Query())->select("id,param_val")->from("t_sys_parameter")->where("type_id=:type_id",['type_id'=>SysParameterType::YES_NO])->orderBy("seq_id")->all();
//     	        $db = Yii::$app->db;
//     	        $yesno_list = $db->createCommand("select id,param_val from t_sys_parameter where type_id=:type_id",['type_id'=>SysParameterType::YES_NO])->queryAll();
//     	        var_dump($yesno_list);

    	/* $payType = new PayType();
    	$payType = PayType::findOne(1);
    	$payType = $payType->toArray();
    	var_dump($payType); */
    	
    	/* $payType = new PayType();
    	$payType->id = 4;
    	var_dump($payType); */
    	
    	return $yesno_list;
    }
}
