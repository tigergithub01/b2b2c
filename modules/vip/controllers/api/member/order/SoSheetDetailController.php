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
    	$searchModel->query_vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$models = $dataProvider->getModels();
    	
    	
    	//格式化输出
    	$data = ArrayHelper::toArray ($models, [
    			SoSheetDetail::className() => array_merge(CommonUtils::getModelFields(new SoSheetDetail()),[
    					'order' => function($value){
    						return $value->order;
    					},
    					'merchant'=> function($value){
    						//统一获取商户信息
    						$merchant = null;
    						$merchant_tmp = null;
    						if($value->product_id){
    							$merchant =  $value->product->vip;
    						}else if($value->package_id){
    							$merchant = $value->package->vip;
    						}
    						
    						if($merchant){
    							$merchant_tmp = new Vip();
    							$merchant_tmp->id = $merchant->id;
    							$merchant_tmp->vip_name = $merchant->vip_name;
    							$merchant_tmp->thumb_url = UrlUtils::formatUrl($merchant->thumb_url);
    							$merchant_tmp->img_url = UrlUtils::formatUrl($merchant->img_url);
    							$merchant_tmp->img_original = UrlUtils::formatUrl($merchant->img_original);
    						}
    						
    						return $merchant_tmp;
    					},
    					'order' => function($value){
    						//订单信息
    						return $value->order;
    					},
    					'order_status_name' => function($value){
		        			return ((empty($value->order) || empty($value->order->orderStatus))?'':$value->order->orderStatus->param_val);
		        		},
		        		'pay_status_name' => function($value){
		        			return ((empty($value->order) || empty($value->order->payStatus))?'':$value->order->payStatus->param_val);
			        	},
			        	'sheet_type_name' => function($value){
			        		return ((empty($value->order) || empty($value->order->sheetType))?'':$value->order->sheetType->name);
				        },
				        'vip_name' => function($value){
				        	return ((empty($value->order) || empty($value->order->vip))?'':$value->order->vip->vip_name);
				        }, 
    					'package' => function($value){
    						//组合服务信息
    						if($value->package){
    							$value->package->thumb_url = UrlUtils::formatUrl($value->package->thumb_url);
    							$value->package->img_url = UrlUtils::formatUrl($value->package->img_url);
    							$value->package->img_original = UrlUtils::formatUrl($value->package->img_original);
    						}
    						return $value->package;
    					 },
    					 'product' => function($value){
	    					 //产品服务
	    					 return $value->product;
    					 },
    				])
    			]);
    	
    	$pagionationObj = new PaginationObj($data, $dataProvider->getTotalCount());
    	return CommonUtils::json_success($pagionationObj);
    }

   
}
