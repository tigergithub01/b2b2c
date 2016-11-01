<?php

namespace app\modules\vip\controllers\api\blog;

use Yii;
use app\modules\vip\common\controllers\BaseApiController;
use app\models\b2b2c\common\JsonObj;
use yii\helpers\Json;
use app\common\utils\UrlUtils;
use app\common\utils\CommonUtils;
use app\models\b2b2c\common\PaginationObj;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\search\VipConcernSearch;
use app\models\b2b2c\VipConcern;
use app\models\b2b2c\search\VipBlogCmtSearch;
use app\models\b2b2c\VipBlogCmt;

/**
 * VipBlogCmtController implements the CRUD actions for VipBlogCmt model.
 */
class VipBlogCmtController extends BaseApiController
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

        $models = $dataProvider->getModels();
        $pagionationObj = new PaginationObj($models, $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single VipBlogCmt model.
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
    	
    	 return $model;
    }
    
    
    
}
