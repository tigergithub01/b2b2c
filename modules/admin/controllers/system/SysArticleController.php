<?php

namespace app\modules\admin\controllers\system;

use Yii;
use app\models\b2b2c\SysArticle;
use app\models\b2b2c\search\SysArticleSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\b2b2c\SysParameterType;
use app\modules\admin\models\AdminConst;
use app\models\b2b2c\SysParameter;

/**
 * SysArticleController implements the CRUD actions for SysArticle model.
 */
class SysArticleController extends BaseAuthController
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
     * Lists all SysArticle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SysArticle model.
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
     * Creates a new SysArticle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SysArticle();
        $model->issue_user_id = \Yii::$app->session->get(AdminConst::LOGIN_ADMIN_USER)->id;
        $model->issue_date = date(AdminConst::DATE_FORMAT,time());
        $model->is_sys_flag = SysParameter::no;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            	'yesNoList'=>SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            ]);
        }
    }

    /**
     * Updates an existing SysArticle model.
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
            return $this->render('update', [
                'model' => $model,
            	'yesNoList'=>SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            ]);
        }
    }

    /**
     * Deletes an existing SysArticle model.
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
     * Finds the SysArticle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SysArticle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = SysArticle::find()->alias("art")
    	->joinWith("isShow shw")
    	->joinWith("isSysFlag sys")
    	->joinWith("issueUser isu")
    	->where(['art.id'=>$id])->one();
    	if ($model !== null) {
//         if (($model = SysArticle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
