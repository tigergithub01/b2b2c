<?php

namespace app\modules\vip\controllers\api\basic;

use app\common\utils\CommonUtils;
use app\common\utils\UrlUtils;
use app\models\b2b2c\Activity;
use app\models\b2b2c\ActPackageProduct;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\search\ActivitySearch;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\SoSheetDetail;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\Vip;
use app\models\b2b2c\VipCollect;
use app\modules\vip\common\controllers\BaseApiController;
use app\modules\vip\service\vip\ActivityService;
use app\modules\vip\service\vip\VipCollectService;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

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
        $searchModel->audit_status = SysParameter::audit_approved;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
		
        $models = $dataProvider->getModels();
        foreach ($models as $vip) {
        	$vip->img_url = UrlUtils::formatUrl($vip->img_url);
        	$vip->thumb_url = UrlUtils::formatUrl($vip->thumb_url);
        	$vip->img_original = UrlUtils::formatUrl($vip->img_original);
        }
        
        //格式化输出
        $data = ArrayHelper::toArray ($models, [
        		Activity::className() => array_merge(CommonUtils::getModelFields(new Activity()),[
        				'collect_count' => function($value){
	        				$vipCollectService = new VipCollectService();
	        				$count = $vipCollectService->getVipCollectCount(VipCollect::collect_act,$value->id);
	        				return $count;
	        			},
        				'order_count' => function($value){
        					$count = SoSheetDetail::find()->alias("detail")
        						->joinWith("order order")
        					->where(['detail.package_id'=>$value->id, 'order.order_status'=>SoSheet::order_completed])->count();
	        				return $count;
        			},
        		])
        ]);
        
        $pagionationObj = new PaginationObj($data, $dataProvider->getTotalCount());
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
    	
    	$actPackageProducts = $this->findActPackageProductList($id);
    	
    	//格式化输出
		$activityService = new ActivityService();
    	
    	return CommonUtils::json_success([
    			"model"=> $activityService->getActivityModelArray($model),
    			'actPackageProducts'=>$activityService->getActPackageProductModelArray($actPackageProducts),
    	]);
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
    	
    	if(empty($model)){
    		throw new \yii\web\NotFoundHttpException('您查找的数据不存在！');
    	}
    	
    	return $model;
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    function findActPackageProductList($act_id){
    	$models = ActPackageProduct::find()->alias('actProd')
    	->joinWith('act act')
    	->joinWith('product product')
    	->joinWith('product.vip vip')
    	->joinWith('product.vip.vipType vipType')
    	->where(['actProd.act_id' => $act_id])->all();
    	
    	return $models;
    }
    
    
}
