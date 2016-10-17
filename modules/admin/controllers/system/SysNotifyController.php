<?php

namespace app\modules\admin\controllers\system;

use Yii;
use app\models\b2b2c\SysNotify;
use app\models\b2b2c\search\SysNotifySearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\SysParameter;

/**
 * SysNotifyController implements the CRUD actions for SysNotify model.
 */
class SysNotifyController extends BaseAuthController
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
     * Lists all SysNotify models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysNotifySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
        		'sendExtendList' => SysParameterType::getSysParametersById(SysParameterType::NOTIFY_EXTEND),
        		'sysUserList' => $this->findSysUserList(),
        		'notifyTypeList' => SysParameterType::getSysParametersById(SysParameterType::NOTIFY_TYPE),
        		'vipList' => $this->findVipList(SysParameter::yes),
        ]);
    }

    /**
     * Displays a single SysNotify model.
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
     * Creates a new SysNotify model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SysNotify();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'sendExtendList' => SysParameterType::getSysParametersById(SysParameterType::NOTIFY_EXTEND),
            		'sysUserList' => $this->findSysUserList(),
            		'notifyTypeList' => SysParameterType::getSysParametersById(SysParameterType::NOTIFY_TYPE),
            		'vipList' => $this->findVipList(SysParameter::yes),
            ]);
        }
    }

    /**
     * Updates an existing SysNotify model.
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
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'sendExtendList' => SysParameterType::getSysParametersById(SysParameterType::NOTIFY_EXTEND),
            		'sysUserList' => $this->findSysUserList(),
            		'notifyTypeList' => SysParameterType::getSysParametersById(SysParameterType::NOTIFY_TYPE),
            		'vipList' => $this->findVipList(SysParameter::yes),
            ]);
        }
    }

    /**
     * Deletes an existing SysNotify model.
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
     * Finds the SysNotify model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SysNotify the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = SysNotify::find()->alias("sysNotify")
    	->joinWith("isSent isSent")
    	->joinWith("sendExtend sendExtend")
    	->joinWith("issueUser issueUser")
    	->joinWith("status0 stat")
    	->joinWith("notifyType notifyType")
    	->joinWith("vip vip")
    	->where(['sysNotify.id' => $id])->one();
    	 
    	if($model){
//         if (($model = SysNotify::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
    protected  function findVipList($merchant_flag){
    	return Vip::find()->where(['merchant_flag'=>$merchant_flag])->all();
    }
}
