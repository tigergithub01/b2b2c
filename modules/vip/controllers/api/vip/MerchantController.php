<?php

namespace app\modules\vip\controllers\api\vip;

use app\common\utils\CommonUtils;
use app\common\utils\UrlUtils;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\Product;
use app\models\b2b2c\ProductComment;
use app\models\b2b2c\search\VipSearch;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\SoSheetVip;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\Vip;
use app\models\b2b2c\VipCase;
use app\models\b2b2c\VipExtend;
use app\models\b2b2c\VipOrganization;
use app\modules\vip\common\controllers\BaseApiController;
use app\modules\vip\service\vip\MerchantService;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * VipController implements the CRUD actions for Vip model.
 */
class MerchantController extends BaseApiController
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
     * Lists all Vip models.
     * @return mixed
     */
    public function actionIndex()
    {
        /* $searchModel = new VipSearch();
        $params = Yii::$app->request->queryParams;
        $params['VipSearch']['audit_status'] = SysParameter::audit_approved; //审核通过
        $dataProvider = $searchModel->search($params); */   
    	
    	$searchModel = new VipSearch();
    	$queryParams = Yii::$app->request->queryParams;
    	$queryParams['VipSearch']['merchant_flag'] = SysParameter::yes;
    	$queryParams['VipSearch']['audit_status'] = SysParameter::audit_approved;
    	$dataProvider = $searchModel->search($queryParams);    	
    	
    	
        $models = $dataProvider->getModels();
        foreach ($models as $vip) {
        	$vip->img_url = UrlUtils::formatUrl($vip->img_url);
        	$vip->thumb_url = UrlUtils::formatUrl($vip->thumb_url);
        	$vip->img_original = UrlUtils::formatUrl($vip->img_original);
        }
        
        
        //格式化输出
        $data = ArrayHelper::toArray ($models, [
        		Vip::className() => array_merge(CommonUtils::getModelFields(new Vip()),[
        			'vip_type_name' => function($value){
        				return (empty($value->vipType)?'':$value->vipType->name);
        			},
        			'description' => function($value){
		    				$vipOrganization =  VipOrganization::find()->where(['vip_id'=>$value->id])->one();
			    			return (empty($vipOrganization)?'':$vipOrganization->description);
			    	},
			    	'order_count' => function($value){
				    	$count = SoSheetVip::find()->alias("soSheetVip")->joinWith("vip vip")->joinWith("order order")
				    	->where(['vip.id' =>$value->id, 'order.order_status' => SoSheet::order_completed ])->count();
			    		return $count;
			    	},
			    	'vip_case_count' => function($value){
				    	//案例数量
				    	$count = VipCase::find()->where(['vip_id' =>$value->id, 'audit_status'=>SysParameter::audit_approved ])->count();
				    	return $count;
			    	},
			    	'good_cmt_count' => function($value){
				    	//好评数量
				    	$count = ProductComment::find()->alias("cmt")->joinWith("product product")->
				    	where(['product.vip_id' => $value->id ,'cmt.status'=>SysParameter::yes, 'cmt.cmt_rank_id'=>[ProductComment::cmt_4_star,ProductComment::cmt_5_star]])
				    	->count();
				    	return $count;
			    	},
			    	'password' => function($value){
				    	//密码设置为空
				    	return null;
			    	},
        		])
        	]);
        
        $pagionationObj = new PaginationObj($data, $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single Vip model.
     * @param string $id
     * @return mixed
     */
    public function actionView()
    {
    	$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
    	$model = $this->findModel($id);
    	
    	//根据商户编号查询此商户对应的个人服务
    	$product = $this->findProduct($model->id);
    	
    	//营业信息
    	$vipOrganization = $this->findVipOrganization($model->id);
    	
    	//格式化
    	$vipOrganization->cover_img_url = UrlUtils::formatUrl($vipOrganization->cover_img_url);
    	$vipOrganization->cover_thumb_url = UrlUtils::formatUrl($vipOrganization->cover_thumb_url);
    	$vipOrganization->cover_img_original = UrlUtils::formatUrl($vipOrganization->cover_img_original);
    	
    	//身份信息
    	$vipExtend = $this->findVipExtend($model->id);
    	
    	
    	//格式化输出
    	$data = ArrayHelper::toArray ($model, [
    			Vip::className() => array_merge(CommonUtils::getModelFields($model),[
    				'vip_type_name' => function($value){
    					return (empty($value->vipType)?'':$value->vipType->name);
    				},
    				'password' => function($value){
	    				//密码设置为空
	    				return null;
    				},
    			])
    	]);
    	
    	return CommonUtils::json_success([
    			"model"=>$data,
    			'product'=>$product,
    			'vipOrganization' => $vipOrganization,
    			'vipExtend' => $vipExtend, 
    	]);
    }
    
    
    /**
     * 案例数量
     * @return string
     */
    public function actionVipCaseCount()
    {
    	$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
    	if(empty($id)){
    		return CommonUtils::json_failed("编号不能为空");
    	}
    	
    	$merchantService = new MerchantService();
    	$count = $merchantService->getVipCaseCount($id);
    	return CommonUtils::json_success($count);
    }
    
    
    /**
     * 动态数量
     * @return string
     */
    public function actionVipBlogCount()
    {
    	$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
    	if(empty($id)){
    		return CommonUtils::json_failed("编号不能为空");
    	}
    	 
    	$merchantService = new MerchantService();
    	$count = $merchantService->getVipBlogCount($id);
    	return CommonUtils::json_success($count);
    }
    
    /**
     * 团体服务数量
     * @return string
     */
    public function actionActivityCount()
    {
    	$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
    	if(empty($id)){
    		return CommonUtils::json_failed("编号不能为空");
    	}
    
    	$merchantService = new MerchantService();
    	$count = $merchantService->getActivityCount($id);
    	return CommonUtils::json_success($count);
    }
    
    /**
     * 评论数量
     * @return string
     */
    public function actionProductCommentCount()
    {
    	$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
    	if(empty($id)){
    		return CommonUtils::json_failed("编号不能为空");
    	}
    
    	$merchantService = new MerchantService();
    	$count = $merchantService->getProductCommentCount($id);
    	return CommonUtils::json_success($count);
    }
    
    
    
	
    /**
     * Finds the Vip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Vip the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = Vip::find()->alias('vip')
    	->joinWith('status0 stat')
    	->joinWith('auditStatus auditStat')
    	->joinWith('auditUser auditStatUsr')
    	->joinWith('emailVerifyFlag emailVerify')
    	->joinWith('parent parent')
    	->joinWith('merchantFlag mercFlag')
    	->joinWith('vipType vType')
    	->joinWith('mobileVerifyFlag mobileVerify')
    	->joinWith('rank rank')
    	->joinWith('sex0 sex')
    	->where(['vip.id'=>$id])->one();
    	
    	$model->img_url = UrlUtils::formatUrl($model->img_url);
    	$model->thumb_url = UrlUtils::formatUrl($model->thumb_url);
    	$model->img_original = UrlUtils::formatUrl($model->img_original);
    	
    	
    	return $model;
    }
    
    /**
     * findProduct
     * @param unknown $id
     * @return unknown
     */
    protected function findProduct($vip_id)
    {
    	$model = Product::find()
    	->where(['vip_id'=>$vip_id, 'service_flag'=>SysParameter::yes])->one();
    	return $model;
    }
    
    
    /**
     * findVipOrganization
     * @param unknown $id
     * @return unknown
     */
    protected function findVipOrganization($vip_id)
    {
    	$model = VipOrganization::find()->alias('vipOrg')
    	->joinWith('auditUser auditUser')
    	->joinWith('auditStatus auditStatus')
    	->joinWith('district district')
    	->joinWith('city city')
    	->joinWith('country country')
    	->joinWith('province province')
    	->joinWith('vip vip')
    	->joinWith('status0 stat')
    	->where(['vipOrg.vip_id'=>$vip_id])->one();
    	return $model;
    }
    
    /**
     * findVipExtend
     * @param unknown $id
     * @return unknown
     */
    protected function findVipExtend($vip_id)
    {
    	$model = VipExtend::find()->alias('vipExtend')
    	->joinWith('auditUser auditUser')
    	->joinWith('auditStatus auditStatus')
    	->joinWith('vip vip')
    	->where(['vipExtend.vip_id'=>$vip_id])->one();
    	return $model;
    }
    
    
    
}
