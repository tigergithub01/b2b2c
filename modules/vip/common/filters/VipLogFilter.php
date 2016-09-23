<?php
namespace app\modules\vip\common\filters;

use Yii;
use yii\base\ActionFilter;
use app\models\b2b2c\Vip;
use yii\helpers\Url;
use app\models\b2b2c\VipOperationLog;
use yii\helpers\Json;
use app\modules\vip\models\VipConst;

class VipLogFilter extends ActionFilter{
	
	public function init(){
		parent::init();
	}
	
	public function beforeAction($action){
		//TODO:
// 		var_dump($action);
// 		Yii::info('AdminLogFilter beforeAction ');
// 		Yii::$app->getSession()->get($key)
// 		Yii::$app->getRequest()->get($key);
// 		Yii::$app->response->redirect("/site/index");
// 		return true;		
// 		Yii::$app->controller->layout='@app/views/layouts/manager.php';
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