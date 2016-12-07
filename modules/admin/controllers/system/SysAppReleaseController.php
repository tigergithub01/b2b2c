<?php

namespace app\modules\admin\controllers\system;

use app\common\utils\MsgUtils;
use app\models\b2b2c\search\SysAppReleaseSearch;
use app\models\b2b2c\SysAppInfo;
use app\models\b2b2c\SysAppRelease;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysParameterType;
use app\modules\admin\common\controllers\BaseAuthController;
use app\modules\admin\models\AdminConst;
use Yii;
use yii\web\NotFoundHttpException;
use app\common\utils\file\FileUtils;
use yii\web\UploadedFile;

/**
 * SysAppReleaseController implements the CRUD actions for SysAppRelease model.
 */
class SysAppReleaseController extends BaseAuthController
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
     * Lists all SysAppRelease models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysAppReleaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SysAppRelease model.
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
     * Creates a new SysAppRelease model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SysAppRelease();
        $model->issue_user_id = \Yii::$app->session->get(AdminConst::LOGIN_ADMIN_USER)->id;
        $model->issue_date = \app\common\utils\DateUtils::formatDatetime();
        $model->force_upgrade = SysParameter::yes;

        if ($model->load(Yii::$app->request->post()) /* && $model->save() */) {
        	
        	$transaction = SysAppRelease::getDb()->beginTransaction();
        	try {
        		
        		//获取文件信息
        		$model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
        		
        		/* 保存失败处理 */
        		if(!($model->save())){
        			$transaction->rollBack();
        			return $this->renderCreate($model);
        		}
        		
        		//上传文件
        		$fileUtils = new FileUtils();
        		$uploadType = "app";
        		if($filename = $fileUtils->uploadFile($model->uploadFile, "uploads/$uploadType", $uploadType)){
        			$model->app_path = $filename;
        			if(!($model->save(true,['app_path']))){
        				$transaction->rollBack();
        				$model->addError("uploadFile",'文件上传失败');
        				
        				//删除文件
        				if(file_exists($filename)){
        					unlink($filename);
        				}
        				
        				return $this->renderCreate($model);
        			}
        		}
        		 
        		$transaction->commit();
        		MsgUtils::success();
        		return $this->redirect(['view', 'id' => $model->id]);
        		 
        	}catch (\Exception $e) {
        		$transaction->rollBack();
        		$model->addError('name',$e->getMessage());
        		return $this->renderCreate($model);
        	}
        } /* else { */
        	return $this->renderCreate($model);
            /* return $this->render('create', [
                'model' => $model,
            	'yesNoList'=>SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'sysAppInfoList' => $this->findSysAppInfoList(),
            ]); */
       /*  } */
    }
    
    
    /**
     * @return Ambigous <string, string>
     */
    protected function renderCreate($model){
    	return $this->render('create', [
    			'model' => $model,
    			'yesNoList'=>SysParameterType::getSysParametersById(SysParameterType::YES_NO),
    			'sysAppInfoList' => $this->findSysAppInfoList(),
    	]);
    }

    /**
     * Updates an existing SysAppRelease model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
        	$transaction = SysAppRelease::getDb()->beginTransaction();
        	try {
        	
        		//获取文件信息
        		$model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
        		
        		//旧文件地址
        		$old_file_name = $model->app_path;
        		
        		/* 保存失败处理 */
        		if(!($model->save())){
        			$transaction->rollBack();
        			return $this->renderUpdate($model);
        		}
        		
        		//上传文件
        		$fileUtils = new FileUtils();
        		$uploadType = "app";
        		if($filename = $fileUtils->uploadFile($model->uploadFile, "uploads/$uploadType", $uploadType)){
        			$model->app_path = $filename;
        			if(!($model->save(true,['app_path']))){
        				$transaction->rollBack();
        				$model->addError("uploadFile",'文件上传失败');
        				
        				//删除文件
        				if(file_exists($filename)){
        					unlink($filename);
        				}
        				
        				return $this->renderUpdate($model);
        			}else{
        				//删除旧文件
        				if(file_exists($old_file_name)){
        					unlink($old_file_name);
        				}
        			}
        		}
        		 
        		$transaction->commit();
        		MsgUtils::success();
        		return $this->redirect(['view', 'id' => $model->id]);
        		 
        	}catch (\Exception $e) {
        		$transaction->rollBack();
        		$model->addError('name',$e->getMessage());
        		return $this->renderUpdate($model);
        	}
        } /* else { */
        	return $this->renderUpdate($model);
        	
            /* return $this->render('update', [
                'model' => $model,
            	'yesNoList'=>SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'sysAppInfoList' => $this->findSysAppInfoList(),
            ]); */
        /* } */
    }
    
    
    /**
     * @return Ambigous <string, string>
     */
    protected function renderUpdate($model){
    	return $this->render('update', [
    			'model' => $model,
    			'yesNoList'=>SysParameterType::getSysParametersById(SysParameterType::YES_NO),
    			'sysAppInfoList' => $this->findSysAppInfoList(),
    	]);
    }
    
    

    /**
     * Deletes an existing SysAppRelease model.
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
     * Finds the SysAppRelease model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SysAppRelease the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SysAppRelease::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findSysAppInfoList(){
    	return SysAppInfo::find()->all();
    }
}
