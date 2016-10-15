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
        return $this->render('view', [
            'model' => $this->findModel($id),
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            		'activityTypeList' => $this->findActivityTypeList(),
            		'vipList' => $this->findVipList(),
            		'sysUserList' => $this->findSysUserList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            ]);
        }
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            		'activityTypeList' => $this->findActivityTypeList(),
            		'vipList' => $this->findVipList(),
            		'sysUserList' => $this->findSysUserList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            ]);
        }
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
}
