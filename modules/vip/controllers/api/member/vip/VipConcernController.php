<?php

namespace app\modules\vip\controllers\api\member\vip;

use Yii;
use app\modules\vip\common\controllers\BaseAuthController;
use app\models\b2b2c\common\JsonObj;
use yii\helpers\Json;
use app\common\utils\UrlUtils;
use app\common\utils\CommonUtils;
use app\models\b2b2c\common\PaginationObj;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\search\VipConcernSearch;
use app\models\b2b2c\VipConcern;
use app\modules\vip\models\VipConst;

/**
 * VipConcernController implements the CRUD actions for VipConcern model.
 */
class VipConcernController extends BaseAuthController
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
     * Lists all VipConcern models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipConcernSearch();
        $searchModel->vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
        $pagionationObj = new PaginationObj($models, $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single VipConcern model.
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
     * Finds the VipConcern model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VipConcern the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = VipConcern::find()->alias('vipConcern')
    	->joinWith('vip vip')
    	->joinWith('refVip refVip')
    	->where(['vipConcern.id' => $id])->one();
    	
    	return $model;
    }
    
    
    
}
