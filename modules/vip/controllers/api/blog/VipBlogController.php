<?php

namespace app\modules\vip\controllers\api\blog;

use app\common\utils\CommonUtils;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\search\VipBlogSearch;
use app\models\b2b2c\VipBlog;
use app\modules\vip\common\controllers\BaseApiController;
use Yii;
use app\models\b2b2c\SysParameter;
use app\modules\vip\service\vip\VipCollectService;
use app\models\b2b2c\VipCollect;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\VipBlogCmt;

/**
 * VipBlogController implements the CRUD actions for VipBlog model.
 */
class VipBlogController extends BaseApiController
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
        $searchModel->audit_status = SysParameter::audit_approved;//审核通过
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        

        $models = $dataProvider->getModels();
        
        //格式化输出
        $data = ArrayHelper::toArray ($models, [
        		VipBlog::className() => array_merge(CommonUtils::getModelFields(new VipBlog()),[
        			'collect_count' => function($value){
        				$vipCollectService = new VipCollectService();
        				$count = $vipCollectService->getVipCollectCount(VipCollect::collect_blog,$value->id);
        				return $count;
        			},
        			'reply_count' => function($value){
        				$count = VipBlogCmt::find()->where(['blog_id'=>$value->id,'status'=>SysParameter::yes])->count();
	        			return $count;
        			},
        		])
        	]);
        
        
        $pagionationObj = new PaginationObj($data, $dataProvider->getTotalCount());
        
        
        
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single VipBlog model.
     * @param string $id
     * @return mixed
     */
    public function actionView()
    {
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
    	$model = $this->findModel($id);
    	
    	return CommonUtils::json_success($model);
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
    	
    	return $model;
    	
    }
}
