<?php

namespace app\modules\admin\controllers\vip;

use Yii;
use app\models\b2b2c\VipCase;
use app\models\b2b2c\search\VipCaseSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\VipCaseType;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysUser;

/**
 * VipCaseController implements the CRUD actions for VipCase model.
 */
class VipCaseController extends BaseAuthController
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
     * Lists all VipCase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipCaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        			'vipCaseTypeList' => $this->findVipCaseTypeList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            		'caseFlagList' => SysParameterType::getSysParametersById(SysParameterType::CASE_FLAG),
            		'vipList' => $this->findVipList(),
            		'sysUserList' => $this->findSysUserList(),
        ]);
    }

    /**
     * Displays a single VipCase model.
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
     * Creates a new VipCase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VipCase();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            		'vipCaseTypeList' => $this->findVipCaseTypeList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            		'caseFlagList' => SysParameterType::getSysParametersById(SysParameterType::CASE_FLAG),
            		'vipList' => $this->findVipList(),
            		'sysUserList' => $this->findSysUserList(),
            ]);
        }
    }

    /**
     * Updates an existing VipCase model.
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
            		'vipCaseTypeList' => $this->findVipCaseTypeList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'auditStatList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            		'caseFlagList' => SysParameterType::getSysParametersById(SysParameterType::CASE_FLAG),
            		'vipList' => $this->findVipList(),
            		'sysUserList' => $this->findSysUserList(),
            ]);
        }
    }

    /**
     * Deletes an existing VipCase model.
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
     * Finds the VipCase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VipCase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = VipCase::find()->alias('case')
    	->joinWith('auditUser auditUser')
        ->joinWith('auditStatus auditStatus')
        ->joinWith('type type')
        ->joinWith('caseFlag caseFlag')
        ->joinWith('status0 stat')
        ->joinWith('status0 isHot')
        ->joinWith('vip vip')
    	->where(['case.id' => $id])->one();
    	if($model !==null){
//     	if (($model = VipCase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipCaseTypeList(){
    	return VipCaseType::find()->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipList(){
    	return Vip::find()->where(['merchant_flag' => SysParameter::yes])->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findSysUserList(){
    	return SysUser::find()->all();
    }
    
    
}
