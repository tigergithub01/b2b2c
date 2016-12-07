<?php
namespace app\modules\admin\common\filters;

use Yii;
use yii\base\Behavior;;
use yii\web\Controller;
use app\modules\admin\models\AdminConst;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\SysOperationLog;
use yii\helpers\Json;
use app\modules\admin\service\system\SysUserService;
use app\models\b2b2c\web\WebUser;

class AdminAuthBehavior extends Behavior{
	
	public function events()
	{
		return [Controller::EVENT_BEFORE_ACTION => 'beforeAction',
				Controller::EVENT_AFTER_ACTION=>'afterAction'];
	}
	
	
	 public function beforeAction($event){
// 	 	var_dump("xxx");
// 	 	Yii::info('AdminAuthBehavior beforeAction' );
	 	
// 	 	var_dump($event->action->controller);
// 	 	var_dump(Yii::$app->requestedRoute);
// 	 	var_dump(Yii::$app);
// 	 	var_dump(Yii::$app->request);
// 	 	var_dump(Yii::$app->request->url);
// 		var_dump($event->action);
	 	
	 	//check cookie for auto login
// 	 	Yii::$app->request->cookies;
	 	$session = Yii::$app->session;
	 	$login_user = $session->get(AdminConst::LOGIN_ADMIN_USER);
	 	$cookies = Yii::$app->request->cookies;
	 	$admin_user_id = $cookies->getValue(AdminConst::COOKIE_ADMIN_USER_ID);
// 	 	$admin_user_id = $_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID];
// 	 	$admin_user_id = $cookies[AdminConst::COOKIE_ADMIN_USER_ID]->value;
	 	if(empty($login_user)){
	 		//记录最后次访问URL
	 		$session->set(AdminConst::ADMIN_LAST_ACCESS_URL,Yii::$app->request->url);
	 		
	 		//是否自动登陆
	 		if($admin_user_id){
	 			//auto login
	 			$model = new SysUser();
	 			$model->setScenario(SysUser::SCENARIO_AUTO_LOGIN);
	 			$model->user_id = $admin_user_id;
	 			$model->password = $cookies->getValue(AdminConst::COOKIE_ADMIN_PASSWORD);
	 			$userService = new SysUserService();
// 	 			if($model->validate() && ($user_db = $model->login())){
	 			if($model->validate() && ($user_db = $userService->login($model,true))){
	 				// 	 			$_SESSION[AdminConst::LOGIN_ADMIN_USER]=$user_db;
	 				//设置用户
	 				$session->set(AdminConst::LOGIN_ADMIN_USER,$user_db->getWebSysUser());
	 				
	 				//设置权限等信息TODO:
	 				
	 			}else{
	 				//自动登陆不成功，可能是用户密码有了变更，用户被禁用；而本地存储的密码没有改变。
	 				Yii::$app->getResponse()->redirect("/admin/system/login/index");
	 			}	
	 		}else{
	 			//redirect to 
	 			Yii::$app->getResponse()->redirect("/admin/system/login/index");
	 		}
	 	}
	 	
		
	 	//check session for user rights(检查用户权限）
	 	
	 	
// 	 	Yii::$app->getResponse()->redirect("/admin/system/login/index");
	 }
	 
	 public function afterAction($event){
	 	//TODO:
// 	 	Yii::info('AdminAuthBehavior afterAction ');
	 	//插入日志
	 	$action = $event->action;
	 	$sys_log = new SysOperationLog();
	 	$session = Yii::$app->session;
	 	$login_user = $session->get(AdminConst::LOGIN_ADMIN_USER);
	 	if($login_user){
	 		$sys_log->user_id = $login_user->id;
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
	 		$sys_log->op_desc = $parameters;
	 	}
	 	$sys_log->insert();
	 	if($sys_log->hasErrors()){
	 		Yii::info($sys_log->getErrors());
	 	}	 	
	 }
	
	/* public function beforeAction($action){
		parent::
		//TODO:
		//var_dump($action);
		Yii::info('AdminAuthBehavior beforeAction ' );
// 		Yii::$app->getSession()->get($key)
// 		Yii::$app->getRequest()->get($key);
// 		Yii::$app->response->redirect("/site/index");
// 		return true;		
// 		Yii::$app->controller->layout='@app/views/layouts/manager.php';
		return parent::beforeAction($action);
	}
	
	public function afterAction($action, $result){
		//TODO:
		Yii::info('AdminAuthBehavior afterAction ');
		return parent::afterAction($action, $result);
	}
	 */
}