<?php
namespace app\modules\merchant\common\filters;

use Yii;
use yii\web\Controller;
use app\modules\merchant\models\MerchantConst;
use app\models\b2b2c\Vip;
use app\modules\merchant\service\vip\MerchantService;
use yii\helpers\Url;
use app\models\b2b2c\VipOperationLog;
use yii\helpers\Json;
use yii\base\ActionFilter;
use app\common\utils\CommonUtils;


class MerchantAuthFilter extends ActionFilter{
	
	public function init(){
		parent::init();
	}
	
	public function beforeAction($action){
		$session = Yii::$app->session;
	 	$login_merchant = $session->get(MerchantConst::LOGIN_MERCHANT_USER);
	 	$cookies = Yii::$app->request->cookies;
	 	$merchant_user_id = $cookies->getValue(MerchantConst::COOKIE_MERCHANT_USER_ID);
	 	if(empty($login_merchant)){
	 		//记录最后次访问URL
	 		$session->set(MerchantConst::MERCHANT_LAST_ACCESS_URL,Yii::$app->request->url);
	 		
	 		//是否自动登陆
	 		if($merchant_user_id){
	 			//auto login
	 			$model = new Vip();
	 			$model->setScenario(Vip::SCENARIO_AUTO_LOGIN);
	 			$model->vip_id = $merchant_user_id;
	 			$model->password = $cookies->getValue(MerchantConst::COOKIE_MERCHANT_PASSWORD);
	 			$merchantService = new MerchantService();
	 			if($model->validate() && ($merchant_db = $merchantService->login($model,true))){
	 				//设置用户
	 				
	 				$session->set(MerchantConst::LOGIN_MERCHANT_USER,$merchant_db->getWebVip());
	 				
	 				//设置权限等信息TODO:
	 				
	 				//TODO:店铺信息与个人信息完善并通过审核后，别人才能看见自己的店铺信息。	
	 				
	 				
	 			}else{
	 				//自动登陆不成功，可能是用户密码有了变更，用户被禁用；而本地存储的密码没有改变。
	 				if (Yii::$app->getRequest()->getIsAjax()) {
	 					CommonUtils::response_failed("请先登陆。", Constant::err_code_no_login);
	 				}else{
	 					Yii::$app->getResponse()->redirect(Url::toRoute(['/merchant/system/login/index']));
	 				}
	 				return false;
	 			}	
	 		}else{
	 			//redirect to 
	 			if (Yii::$app->getRequest()->getIsAjax()) {
	 				CommonUtils::response_failed("请先登陆。", Constant::err_code_no_login);
	 			}else{
	 				Yii::$app->getResponse()->redirect(Url::toRoute(['/merchant/system/login/index']));
	 			}
	 			return false;
	 		}
	 	}
		return parent::beforeAction($action);
	}
	
	public function afterAction($action, $result){
	 	//插入日志
	 	$sys_log = new VipOperationLog();
	 	$session = Yii::$app->session;
	 	$login_merchant = $session->get(MerchantConst::LOGIN_MERCHANT_USER);
	 	if($login_merchant){
	 		$sys_log->vip_id = $login_merchant->id;
	 	}
	 	$sys_log->op_date=\app\common\utils\DateUtils::formatDatetime();
	 	$sys_log->op_ip_addr = Yii::$app->request->userIP;
	 	$sys_log->op_browser_type = Yii::$app->request->userAgent;
	 	$sys_log->op_url = Yii::$app->request->url;
	 	/* var_dump($action->controller->module->id);
	 	 var_dump($action->controller->id);
	 	 var_dump($action->id); */
	 	// 	 	var_dump(Yii::$app->request->userAgent);
	 	$sys_log->op_method = Yii::$app->request->method;
	 	$sys_log->op_referrer = Yii::$app->request->referrer;
	 	$sys_log->op_module = $action->controller->module->id;
	 	$sys_log->op_controller = $action->controller->id;
	 	$sys_log->op_action = $action->id;
	 	/* var_dump(Json::encode($_REQUEST)); */
	 	if(isset($_REQUEST)){
	 		$parameters = Json::encode($_REQUEST);
	 		$sys_log->op_desc = substr($parameters, 0, 4000);
	 	}
	 	$sys_log->insert();
	 	if($sys_log->hasErrors()){
	 		Yii::info($sys_log->getErrors());
	 	}
		return parent::afterAction($action, $result);
	}
	
}