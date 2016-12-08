<?php

namespace app\modules\merchant\controllers;

use Yii;
use yii\web\Controller;
use app\modules\merchant\models\MerchantConst;
use app\modules\merchant\common\controllers\BaseAuthController;
use app\modules\merchant\service\vip\MerchantService;
use app\common\utils\MsgUtils;
use yii\helpers\Url;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\VipCase;
use app\models\b2b2c\Activity;
use app\models\b2b2c\RefundSheetApply;
use app\models\b2b2c\VipBlog;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\SoSheetVip;


/**
 * Default controller for the `merchant` module
 */
class DefaultController extends BaseAuthController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$vip_id = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
    	$vip = Vip::findOne($vip_id);
    	
    	if($vip->audit_status==SysParameter::audit_need_submit){
       	 	MsgUtils::warning('<a href="'. Url::toRoute(['/merchant/vip/merchant/view']) .'">温馨提醒：请先完善个人资料并提交审核，个人资料审核通过后，您的服务才能被用户看见！</a>');
    	}elseif ($vip->audit_status==SysParameter::audit_rejected){
    		MsgUtils::warning('<a href="'. Url::toRoute(['/merchant/vip/merchant/view']) .'">温馨提醒：个人资料审核不成功，请先完善个人资料，个人资料审核通过后，您的服务才能被用户看见！</a>');
    	}elseif ($vip->audit_status==SysParameter::audit_need_approve){
    		MsgUtils::info("温馨提醒：您的资料已经提交，我们将尽快审核您提交的资料！");
    	}     
    	
    	
    	// 待审核案例
    	$need_approve_case_count = VipCase::find ()->where ( [
    			'audit_status' => SysParameter::audit_need_approve,
    			'vip_id' => $vip_id,
    	] )->count ();
    	
    	// 待审核团体服务
    	$need_approve_act_count = Activity::find ()->where ( [
    			'audit_status' => SysParameter::audit_need_approve,
    			'vip_id' => $vip_id,
    	] )->count ();
    	
    	// 待处理退款申请
    	$query = RefundSheetApply::find()->alias("rsa")->joinWith("order order")->where(['rsa.status'=>RefundSheetApply::status_need_confirm]);
    	$subquery = SoSheetVip::find()->select(['order_id'])->where(['vip_id'=>$vip_id])->column();
    	$query->andFilterWhere(['order.id' => $subquery]);
    	$need_approve_refund_apply_count =$query->count ();
    	
    	// 待审核商户动态
    	$need_approve_merchant_blog_count = VipBlog::find ()->where ( [
    			'blog_flag' => VipBlog::blog_flag_merchant,
    			'audit_status' => SysParameter::audit_need_approve,
    			'vip_id' => $vip_id,
    	] )->count ();
    	
    	//待接单订单
    	$query = SoSheet::find()->alias("so")->where(['so.order_status'=>SoSheet::order_need_schedule]);
    	$subquery = SoSheetVip::find()->select(['order_id'])->where(['vip_id'=>$vip_id])->column();
    	$query->andFilterWhere(['so.id' => $subquery]);
    	$need_schedule_order =$query->count ();
    	
    	
    	
    	// output
    	$model ['need_approve_case_count'] = $need_approve_case_count;
    	$model ['need_approve_act_count'] = $need_approve_act_count;
    	$model ['need_approve_refund_apply_count'] = $need_approve_refund_apply_count;
    	$model ['need_approve_merchant_blog_count'] = $need_approve_merchant_blog_count;
    	$model ['need_schedule_order'] = $need_schedule_order;
    	
    	
    	return $this->render ( 'index', [
    			'model' => $model
    	] );
    }
    
    
    /**
     * 注销
     */
    public function actionLogout()
    {
    	$service = new MerchantService();
    	$service->logout();
    	
    	Yii::$app->getResponse()->redirect("/merchant/system/login/index");
    }
    
}
