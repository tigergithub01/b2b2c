<?php

namespace app\modules\vip\controllers\api\member\system;

use Yii;
use app\modules\vip\common\controllers\BaseAuthApiController;
use app\models\b2b2c\common\JsonObj;
use yii\helpers\Json;
use app\common\utils\UrlUtils;
use app\common\utils\CommonUtils;
use app\models\b2b2c\common\PaginationObj;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\SysNotifyLog;
use app\models\b2b2c\search\SysNotifyLogSearch;

/**
 * SysNotifyLogController implements the CRUD actions for SysNotifyLog model.
 */
class SysNotifyLogController extends BaseAuthApiController
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
     * Lists all SysNotifyLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysNotifyLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
        $pagionationObj = new PaginationObj($models, $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single SysNotifyLog model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
    	$model = $this->findModel($id);
    	
    	return CommonUtils::json_success($model);
    }


    /**
     * Finds the SysNotifyLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SysNotifyLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = SysNotifyLog::find()->alias('notifyLog')
    	->joinWith('vip vip')
    	->joinWith('notify notify')
    	->where(['notifyLog.id'=>$id])->one();
    	
    	return $model;
    }
}
