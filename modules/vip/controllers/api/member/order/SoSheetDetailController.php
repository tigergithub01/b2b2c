<?php

namespace app\modules\vip\controllers\api\member\order;

use app\common\utils\CommonUtils;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\search\SoSheetDetailSearch;
use app\models\b2b2c\SoSheetDetail;
use app\models\b2b2c\Vip;
use app\modules\vip\common\controllers\BaseAuthApiController;
use app\modules\vip\models\VipConst;
use Yii;
use yii\helpers\ArrayHelper;
use app\common\utils\UrlUtils;
use app\modules\vip\service\order\SoSheetService;

/**
 * SoSheetDetailController implements the CRUD actions for SoSheetDetail model.
 */
class SoSheetDetailController extends BaseAuthApiController
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
     * Lists all SoSheetDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$searchModel = new SoSheetDetailSearch();
    	$searchModel->vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$models = $dataProvider->getModels();
    	
    	//格式化输出
    	$soSheetService = new SoSheetService();
    	
    	$pagionationObj = new PaginationObj($soSheetService->getSoSheetDetailModelArray($models), $dataProvider->getTotalCount());
    	return CommonUtils::json_success($pagionationObj);
    }

   
}
