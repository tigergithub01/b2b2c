<?php

namespace app\modules\admin\controllers\blog;

use Yii;
use app\models\b2b2c\VipBlogCmt;
use app\models\b2b2c\search\VipBlogCmtSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\VipBlog;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\Vip;
use app\modules\admin\models\AdminConst;

/**
 * VipBlogCmtController implements the CRUD actions for VipBlogCmt model.
 */
class VipBlogCmtController extends BaseAuthController
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
     * Lists all VipBlogCmt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipBlogCmtSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'vipList' => $this->findVipList(),
        		'vipBlogList'=>$this->findVipBlogList(),
        		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
        ]);
    }

    /**
     * Displays a single VipBlogCmt model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        		'vipList' => $this->findVipList(),
        		'vipBlogList'=>$this->findVipBlogList(),
        		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
        ]);
    }

    /**
     * Creates a new VipBlogCmt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VipBlogCmt();
        $model->reply_date = \app\common\utils\DateUtils::formatDatetime();
        $model->status = SysParameter::no;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            	'vipList' => $this->findVipList(),
            	'vipBlogList'=>$this->findVipBlogList(),
            	'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            ]);
        }
    }

    /**
     * Updates an existing VipBlogCmt model.
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
            	'vipBlogList'=>$this->findVipBlogList(),
            	'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            ]);
        }
    }

    /**
     * Deletes an existing VipBlogCmt model.
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
     * Finds the VipBlogCmt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VipBlogCmt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        
    	$model = VipBlogCmt::find()->alias('vipBlogCmt')
    	->joinWith('blog blog')
    	->joinWith('vip vip')
    	->joinWith('status0 stat')
    	->joinWith('parent parent')
    	->where(['vipBlogCmt.id' => $id])->one();
    	
    	if($model !==null){
    	// if (($model = VipBlogCmt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipBlogList(){
    	return VipBlog::find()->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipList(){
    	return Vip::find()->where(['merchant_flag'=>SysParameter::no])->all();
    }
    
    
}
