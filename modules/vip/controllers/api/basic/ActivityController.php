<?php

namespace app\modules\vip\controllers\api\basic;

use Yii;
use app\modules\vip\common\controllers\BaseApiController;
use app\models\b2b2c\SysAdInfo;
use app\models\b2b2c\common\JsonObj;
use yii\helpers\Json;
use app\common\utils\UrlUtils;
use app\models\b2b2c\app\models\b2b2c;
use app\common\utils\CommonUtils;
use app\models\b2b2c\search\VipCaseSearch;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\VipCase;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\search\MerchantSearch;
use app\models\b2b2c\Vip;
use app\models\b2b2c\search\ActivitySearch;
use app\models\b2b2c\Activity;

/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends BaseApiController
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
		
        $models = $dataProvider->getModels();
        foreach ($models as $vip) {
        	$vip->img_url = UrlUtils::formatUrl($vip->img_url);
        	$vip->thumb_url = UrlUtils::formatUrl($vip->thumb_url);
        	$vip->img_original = UrlUtils::formatUrl($vip->img_original);
        }
        $pagionationObj = new PaginationObj($models, $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single Activity model.
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
    	
    	$model->img_url = UrlUtils::formatUrl($model->img_url);
    	$model->thumb_url = UrlUtils::formatUrl($model->thumb_url);
    	$model->img_original = UrlUtils::formatUrl($model->img_original);
    	
    	return $model;
    }
    
    
}
