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
    	$id = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
    	$model = Vip::findOne($id);
    	
    	if($model->audit_status==SysParameter::audit_need_submit){
       	 	MsgUtils::warning('<a href="'. Url::toRoute(['/merchant/vip/merchant/view']) .'">温馨提醒：请先完善个人资料，个人资料审核通过后，您的服务才能被用户看见！</a>');
    	}elseif ($model->audit_status==SysParameter::audit_rejected){
    		MsgUtils::warning('<a href="'. Url::toRoute(['/merchant/vip/merchant/view']) .'">温馨提醒：个人资料审核不成功，请先完善个人资料，个人资料审核通过后，您的服务才能被用户看见！</a>');
    	}elseif ($model->audit_status==SysParameter::audit_need_approve){
    		MsgUtils::info("温馨提醒：您的资料已经提交，我们将尽快审核您提交的资料！");
    	}
        
    	return $this->render('index');
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
