<?php

namespace app\modules\admin\controllers\system;

use Yii;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\search\SysUserSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\SysParameter;
use yii\helpers\Json;

/**
 * SysUserController implements the CRUD actions for SysUser model.
 */
class SysUserController extends BaseAuthController
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
     * Lists all SysUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        //get data from hasMany
//         $param_type = SysParameterType::findOne(SysParameterType::YES_NO);
//         $params = $param_type->getSysParameters()->all();
//         var_dump($params);

        //LEFT JOIN   
        /* not works why? */
       /* $params = SysParameter::find()->joinWith([
		    'type' => function ($query) {
		        $query->onCondition(['type.id' => SysParameterType::YES_NO]);
		    },
		])->all(); */
       
       
        /* $params = SysParameter::find()->f
        ->leftJoin('t_sys_parameter_type', 'type_id = t_sys_parameter_type.id')
        ->where(['t_sys_parameter_type.id' => SysParameterType::YES_NO])
        ->all();
        var_dump($params); */

       /* $params =  SysParameter::findBySql("select a.id,a.param_val from t_sys_parameter a LEFT JOIN t_sys_parameter_type b on (a.type_id = b.id) WHERE a.type_id=:type_id",['type_id'=>SysParameterType::YES_NO])->all();
       var_dump($params); */
       
       /*  $params = SysParameterType::getSysParametersById(SysParameterType::YES_NO);
        var_dump($params); */
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'yesNoList'=> SysParameterType::getSysParametersById(SysParameterType::YES_NO),
        ]);
    }

    /**
     * Displays a single SysUser model.
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
     * Creates a new SysUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SysUser();       
        $model->setScenario(SysUser::SCENARIO_NEW_USER);
        //设置默认值
        $model->status = SysParameter::yes;
        
        if ($model->load(Yii::$app->request->post())) {
        	//创建新用户
        	$_user = new SysUser();    
        	$_user->user_id = $model->user_id;
        	$_user->password = md5($model->password);//加密
        	$_user->is_admin = SysParameter::no;//设置为非超级管理员
        	$_user->status  = $model->status;
        	
        	if($_user->save()){
        		return $this->redirect(['view', 'id' => $_user->id]);
        	}else{
        		var_dump($model->getErrors());
        		return $this->render('create', [
        				'model' => $model,
        				'yesNoList'=> SysParameterType::getSysParametersById(SysParameterType::YES_NO),
        		]);
        	}
        } else {
        	Yii::info($model->getErrors());
//         	$model->addError('user_id',Json::encode($model->errors));
            return $this->render('create', [
                'model' => $model,
            	'yesNoList'=> SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            ]);
        }
    }

    /**
     * Updates an existing SysUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
//         	var_dump($model->getErrors());
            return $this->render('update', [
                'model' => $model,
            	'yesNoList'=> SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            ]);
        }
    }

    /**
     * Deletes an existing SysUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SysUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SysUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SysUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * 修改密码
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionChangePwd($id)
    {
    	$model = $this->findModel($id);
    	$model->setScenario(SysUser::SCENARIO_CHANGE_PWD_ADMIN);
    	$model->password = null;
    	$model->confirm_pwd = null;
    
    	if ($model->load(Yii::$app->request->post())) {
    		$valid = $model->validate();
    		if($valid){
    			$password = md5($model->password);
    			$model->password = $password;
    			$model->confirm_pwd = $password;
    			if($model->update(true,['password'])){
    				return $this->redirect(['view', 'id' => $model->id]);
    			}
    		}
    		return $this->render('changePwd', [
    					'model' => $model,
    			]);
    	} else {
    		return $this->render('changePwd', [
    				'model' => $model,
    		]);
    	}
    }
}
