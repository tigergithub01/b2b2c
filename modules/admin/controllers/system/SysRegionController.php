<?php

namespace app\modules\admin\controllers\system;

use Yii;
use app\models\b2b2c\SysRegion;
use app\models\b2b2c\search\SysRegionSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\SysParameterType;
use app\common\utils\CommonUtils;

/**
 * SysRegionController implements the CRUD actions for SysRegion model.
 */
class SysRegionController extends BaseAuthController
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
     * Lists all SysRegion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysRegionSearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//         var_dump($searchModel);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'regionTypeList' => SysParameterType::getSysParametersById(SysParameterType::REGION_TYPE),
        ]);
    }

    /**
     * Displays a single SysRegion model.
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
     * Creates a new SysRegion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SysRegion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            	'regionTypeList' => SysParameterType::getSysParametersById(SysParameterType::REGION_TYPE),
            ]);
        }
    }

    /**
     * Updates an existing SysRegion model.
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
            	'regionTypeList' => SysParameterType::getSysParametersById(SysParameterType::REGION_TYPE),
            ]);
        }
    }

    /**
     * Deletes an existing SysRegion model.
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
     * Finds the SysRegion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SysRegion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = SysRegion::find()->alias('reg')->joinWith('parent p')->joinWith('regionType t')->where(['reg.id'=>$id])->one();
//         if (($model = SysRegion::findOne($id)) !== null) {
    	if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
}
