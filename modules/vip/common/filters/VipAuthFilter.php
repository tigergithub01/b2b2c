<?php
namespace app\modules\vip\common\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\Controller;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\Vip;
use yii\helpers\Url;
use app\modules\vip\models\VipConst;
use app\common\utils\CommonUtils;
use app\models\b2b2c\common\Constant;
use app\modules\vip\service\vip\VipService;

class VipAuthFilter extends ActionFilter{
	
	public function init(){
		parent::init();
	}
	
	public function beforeAction($action){
		$session = Yii::$app->session;
		$login_vip = $session->get(VipConst::LOGIN_VIP_USER);
		$cookies = Yii::$app->request->cookies;
		$vip_user_id = $cookies->getValue(VipConst::COOKIE_VIP_USER_ID);
		// 	 	$admin_user_id = $_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID];
		// 	 	$admin_user_id = $cookies[AdminConst::COOKIE_ADMIN_USER_ID]->value;
		if(empty($login_vip)){
			//记录最后次访问URL
			$session->set(VipConst::VIP_LAST_ACCESS_URL,Yii::$app->request->url);
		
			//是否自动登陆
			if($vip_user_id){
				//auto login
				$model = new Vip();
				$model->setScenario(Vip::SCENARIO_AUTO_LOGIN);
				$model->vip_id = $vip_user_id;
				$model->password = $cookies->getValue(VipConst::COOKIE_VIP_PASSWORD);
				$vipService = new VipService();
				// 	 			if($model->validate() && ($user_db = $model->login())){
				if($model->validate() && ($vip_db = $vipService->login($model,true))){
					// 	 			$_SESSION[AdminConst::LOGIN_ADMIN_USER]=$user_db;
					//设置用户
					$session->set(VipConst::LOGIN_VIP_USER,$vip_db);
		
					//设置权限等信息TODO:
		
		
				}else{
					//自动登陆不成功，可能是用户密码有了变更，用户被禁用；而本地存储的密码没有改变。
					if (Yii::$app->getRequest()->getIsAjax()) {
						CommonUtils::response_failed("请先登陆。", Constant::err_code_no_login);
						return false;
					}else{
						Yii::$app->getResponse()->redirect(Url::toRoute(['/vip/member/system/login/index']));
						return false;
					}
				}
			}else{
				//redirect to
				if (Yii::$app->getRequest()->getIsAjax()) {
					CommonUtils::response_failed("请先登陆。", Constant::err_code_no_login);
					return false;
				}else{
					Yii::$app->getResponse()->redirect(Url::toRoute(['/vip/member/system/login/index']));
					// 	 				exit;
					return false;
				}
			 	
				//
			}
			}
		return parent::beforeAction($action);
	}
	
	public function afterAction($action, $result){
		//TODO:
// 		Yii::info('AdminLogFilter afterAction ');

		//插入日志
		$sys_log = new VipOperationLog();
		$session = Yii::$app->session;
		$login_user = $session->get(VipConst::LOGIN_VIP_USER);
		if($login_user){
			$sys_log->vip_id = $login_user->id;
		}
		$sys_log->op_date=date(VipConst::DATE_FORMAT,time());
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
			$sys_log->op_desc = $parameters;
		}
		$sys_log->insert();
		if($sys_log->hasErrors()){
			Yii::info($sys_log->getErrors());
		}
		return parent::afterAction($action, $result);
	}
	
}