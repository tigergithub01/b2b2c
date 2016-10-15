<?php

namespace app\modules\admin\controllers\blog;

use Yii;
use app\models\b2b2c\VipBlog;
use app\models\b2b2c\search\VipBlogSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\Vip;
use app\models\b2b2c\VipBlogType;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\SysParameter;

/**
 * VipBlogController implements the CRUD actions for VipBlog model.
 */
class VipBlogController extends BaseAuthController
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
     * Lists all VipBlog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipBlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'vipList' => $this->findVipList(),
        		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
        		'blogFlagList' => SysParameterType::getSysParametersById(SysParameterType::BLOG_FLAG),
        		'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
        		'vipBlogTypeList' => $this->findVipBlogTypeList(),
        ]);
    }

    /**
     * Displays a single VipBlog model.
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
     * Creates a new VipBlog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VipBlog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            		'vipList' => $this->findVipList(),
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'blogFlagList' => SysParameterType::getSysParametersById(SysParameterType::BLOG_FLAG),
            		'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            		'vipBlogTypeList' => $this->findVipBlogTypeList(),
            		'sysUserList' => $this->findSysUserList(),
            ]);
        }
    }

    /**
     * Updates an existing VipBlog model.
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
            	'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'blogFlagList' => SysParameterType::getSysParametersById(SysParameterType::BLOG_FLAG),
            	'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            	'vipBlogTypeList' => $this->findVipBlogTypeList(),
            	'sysUserList' => $this->findSysUserList(),
            ]);
        }
    }

    /**
     * Deletes an existing VipBlog model.
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
     * Finds the VipBlog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VipBlog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = VipBlog::find()->alias('vipBlog')
    	->joinWith('vip vip')
    	->joinWith('status0 stat')
    	->joinWith('blogFlag blogFlag')
    	->joinWith('blogType blogType')
    	->joinWith('auditStatus auditStatus')
    	->joinWith('auditUser auditUser')
    	->where(['vipBlog.id'=>$id])->one();
    	
    	if($model){
//         if (($model = VipBlog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findVipList(){
    	$vipList = Vip::find()->all();
    	foreach ($vipList as $key => $model) {
    		$model->vip_id = $model->vip_id . (($model->merchant_flag==SysParameter::yes)?'(商户)':'(会员)');
    	}
    	return $vipList;
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipBlogTypeList(){
    	return VipBlogType::find()->all();
    }
    
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findSysUserList(){
    	return SysUser::find()->all();
    }
}
