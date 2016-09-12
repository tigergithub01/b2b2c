<?php
namespace app\modules\admin\common\filters;

use Yii;
use yii\base\Behavior;;
use yii\web\Controller;
use app\modules\admin\models\AdminConst;
use app\models\b2b2c\SysUser;

class AdminAuthBehavior extends Behavior{
	
	public function events()
	{
		return [Controller::EVENT_BEFORE_ACTION => 'beforeAction',
				Controller::EVENT_AFTER_ACTION=>'afterAction'];
	}
	
	
	 public function beforeAction($event){
// 	 	var_dump("xxx");
	 	Yii::info('AdminAuthBehavior beforeAction' );
	 	
	 	//check cookie for auto login
// 	 	Yii::$app->request->cookies;
	 	$session = Yii::$app->session;
	 	$login_user = $session->get(AdminConst::LOGIN_ADMIN_USER);
	 	
	 	$cookies = Yii::$app->request->cookies;
	 	$admin_user_id = $cookies->getValue(AdminConst::COOKIE_ADMIN_USER_ID);
// 	 	$admin_user_id = $_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID];
// 	 	$admin_user_id = $cookies[AdminConst::COOKIE_ADMIN_USER_ID]->value;
	 	if($admin_user_id && empty($login_user)){
	 		//auto login
	 		$model = new SysUser();
	 		$model->setScenario(SysUser::SCENARIO_AUTO_LOGIN);
	 		$model->user_id = $admin_user_id;
	 		$model->password = $cookies->getValue(AdminConst::COOKIE_ADMIN_PASSWORD);
	 		$user_db = null;
	 		if($model->validate() && ($user_db = $model->login())){
// 	 			$_SESSION[AdminConst::LOGIN_ADMIN_USER]=$user_db;
	 			//设置用户
	 			$session->set(AdminConst::LOGIN_ADMIN_USER,$user_db);
	 			
	 			//设置会话
	 		}
	 	}
	 	
		
	 	//check session for user rights
	 	
	 	if(empty($login_user)){
	 		Yii::$app->getResponse()->redirect("/admin/system/login/index");
	 	}
// 	 	Yii::$app->getResponse()->redirect("/admin/system/login/index");
	 }
	 
	 public function afterAction($event){
	 	//TODO:
// 	 	Yii::info('AdminAuthBehavior afterAction ');
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