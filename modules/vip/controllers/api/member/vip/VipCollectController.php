<?php

namespace app\modules\vip\controllers\api\member\vip;

use app\common\utils\CommonUtils;
use app\common\utils\UrlUtils;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\ProductComment;
use app\models\b2b2c\search\VipCollectSearch;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\VipCase;
use app\models\b2b2c\VipCollect;
use app\modules\vip\common\controllers\BaseAuthApiController;
use app\modules\vip\models\VipConst;
use app\modules\vip\service\vip\VipCollectService;
use Yii;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\SoSheetVip;

/**
 * VipCollectController implements the CRUD actions for VipCollect model.
 */
class VipCollectController extends BaseAuthApiController
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
     * Lists all VipCollect models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipCollectSearch();
        $searchModel->vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
       
        //格式化输出
        $data = ArrayHelper::toArray ($models, [
        		VipCollect::className() => array_merge(CommonUtils::getModelFields(new VipCollect()),[
        			'vip_name' => function($value){
    						return (empty($value->vip)?'':$value->vip->vip_name);
    					},
        			'thumb_url' => function($value){
        				return (empty($value->vip)?'':UrlUtils::formatUrl($value->vip->thumb_url));
        				},
        			/* 'activity_count' => function($value){
        				//团体数量
        				if(empty($value->vip)){
        					return 0;
        				}else{
        					$count = Activity::find()->where(['vip_id' =>$value->vip->id, 'activity_type'=>Activity::act_package, 'audit_status'=>SysParameter::audit_approved ])->count();
        					return $count;
        				}
        			}, */
        			'order_count' => function($value){
	        			//成交量
	        			if(empty($value->refVip)){
	        				return 0;
	        			}else{
	        				$count = SoSheetVip::find()->alias("soSheetVip")->joinWith("vip vip")->joinWith("order order")
	        				->where(['vip.id' =>$value->refVip->id, 'order.order_status' => SoSheet::order_completed ])->count();
	        				return $count;
	        			}
        			},
        			'vip_case_count' => function($value){
	        			//案例数量
	        			if(empty($value->refVip)){
	        				return 0;
	        			}else{
	        				$count = VipCase::find()->where(['vip_id' =>$value->refVip->id, 'audit_status'=>SysParameter::audit_approved ])->count();
	        				return $count;
	        			}
        			},
        			/* 'collect_count' => function($value){
        				//收藏数量
        				if(empty($value->vip)){
        					return 0;
        				}else{
        					$vipCollectService = new VipCollectService();
        					return $vipCollectService->getVipCollectCount(VipCollect::collect_vip, $value->vip->id);
        				}        				
        			}, */
        			'good_cmt_count' => function($value){
	        			//好评数量
	        			if(empty($value->refVip)){
	        				return 0;
	        			}else{
	        				$count = ProductComment::find()->alias("cmt")->joinWith("product product")->
	        				where(['product.vip_id' => $value->refVip->id ,'cmt.status'=>SysParameter::yes, 'cmt.cmt_rank_id'=>[ProductComment::cmt_4_star,ProductComment::cmt_5_star]])
	        				->count();
	        				return $count;
	        			}
        			},
        			'vip_case_name' => function($value){
        				//案例名称
        				return (empty($value->case)?'':$value->case->name);
        			},
        			'vip_case_sale_price' => function($value){
        				//案例价格
        				return (empty($value->case)?'':$value->case->sale_price);
        			},
        		])
        	]);
        
        $pagionationObj = new PaginationObj($data, $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single VipCollect model.
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
     * 获取收藏的数量
     * @param string $id
     * @return mixed
     */
    public function actionCount()
    {
    	$ref_id = isset($_REQUEST['ref_id'])?$_REQUEST['ref_id']:null; //关联收藏对象编号
    	$collect_type = isset($_REQUEST['collect_type'])?$_REQUEST['collect_type']:null; //收藏类型
    	
    	if(empty($ref_id)){
    		return CommonUtils::json_failed("编号不能为空");
    	}
    	 
    	if(empty($collect_type)){
    		return CommonUtils::json_failed("取消收藏类型不能为空");
    	}
    	
    	$vipCollectService = new VipCollectService();
    	$count = $vipCollectService->getVipCollectCount($collect_type, $ref_id);
    	 
    	return CommonUtils::json_success($count);
    }
    
    /**
     * Creates a new VipCollect model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new VipCollect();
    	$vip_user = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER);  
    	$ref_id = isset($_REQUEST['ref_id'])?$_REQUEST['ref_id']:null; //关联收藏对象编号
    	
    	$model->vip_id = $vip_user->id;
    	$model->collect_date = date(VipConst::DATE_FORMAT, time());
    	
    	$vipCollectService = new VipCollectService();
    	
    	
    	if ($model->load(Yii::$app->request->post()) && $model->validate() /* && $model->save() */) {
    		if(empty($ref_id)){
    			return CommonUtils::json_failed('收藏对象不能为空！');
    		}
    		
    		$count = $vipCollectService->getVipCollectCount($model->collect_type, $ref_id, $model->vip_id);
    		if($count>=1){
    			return CommonUtils::json_failed("不能重复收藏!");
    		}
    		
    		if($vipCollectService->saveVipCollect($model, $ref_id)){
    			return CommonUtils::json_success($model->id);
    		}
    	} 
    	
    	return CommonUtils::jsonMsgObj_failed('收藏失败！', $model);
    }
    
    
    /**
     * Deletes an existing VipCollect model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
    	$vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id; //会员编号
    	$ref_id = isset($_REQUEST['ref_id'])?$_REQUEST['ref_id']:null; //关联收藏对象编号
    	$collect_type = isset($_REQUEST['collect_type'])?$_REQUEST['collect_type']:null; //收藏类型
    	if(empty($ref_id)){
    		return CommonUtils::json_failed("编号不能为空");
    	}
    	
    	if(empty($collect_type)){
    		return CommonUtils::json_failed("取消收藏类型不能为空");
    	}
    	
    	$vipCollectService = new VipCollectService();
    	$model = $vipCollectService->getVipCollect($vip_id, $collect_type, $ref_id);
    	if(empty($model)){
    		return CommonUtils::json_failed("收藏不存在！");
    	}
    	
    	$model->delete();
    	
    	return CommonUtils::json_successWithMsg("取消收藏成功！");
    }


    /**
     * Finds the VipCollect model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VipCollect the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = VipCollect::find()->alias('vipCollect')
    	->joinWith('vip vip')
    	->joinWith('package package')
    	->joinWith('case case')
    	->joinWith('product product')
    	->where(['vipCollect.id' => $id])->one();
    	
    	return $model;
    }
}
