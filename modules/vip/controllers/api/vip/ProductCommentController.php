<?php

namespace app\modules\vip\controllers\api\vip;

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
use app\models\b2b2c\search\ProductCommentSearch;
use app\models\b2b2c\ProductComment;

/**
 * ProductCommentController implements the CRUD actions for ProductComment model.
 */
class ProductCommentController extends BaseApiController
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
     * Lists all ProductComment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
        $pagionationObj = new PaginationObj($models, $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single ProductComment model.
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
     * Finds the ProductComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        
    	$model = ProductComment::find()->alias('pcmt')
    	->joinWith('status0 stat')
    	->joinWith('cmtRank cmtRank')
    	->joinWith('parent parent')
    	->joinWith('vip vip')
    	->joinWith('product prod')
    	->where(['pcmt.id'=>$id])->one();
    	
    	return $model;
    }
    
    
}
