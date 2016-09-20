<?php
namespace app\modules\merchant\common\filters;

use Yii;
use yii\base\Behavior;;
use yii\web\Controller;
use app\models\b2b2c\SysUser;
use app\modules\merchant\models\MerchantConst;

class MerchantAuthBehavior extends Behavior{
	
	public function events()
	{
		return [Controller::EVENT_BEFORE_ACTION => 'beforeAction',
				Controller::EVENT_AFTER_ACTION=>'afterAction'];
	}
	
	
	 public function beforeAction($event){
	 	//check cookie for auto login
// 	 	Yii::$app->request->cookies;
	 	$session = Yii::$app->session;
	 	$login_user = $session->get(MerchantConst::LOGIN_MERCHANT_USER);
	 	$cookies = Yii::$app->request->cookies;
	 	$merchant_user_id = $cookies->getValue(MerchantConst::COOKIE_MERCHANT_USER_ID);
// 	 	$admin_user_id = $_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID];
// 	 	$admin_user_id = $cookies[AdminConst::COOKIE_ADMIN_USER_ID]->value;
	 	if(empty($login_user)){
	 		//记录最后次访问URL
	 		$session->set(MerchantConst::MERCHANT_LAST_ACCESS_URL,Yii::$app->request->url);
	 		
	 		//是否自动登陆
	 		if($merchant_user_id){
	 			//auto login
	 			$model = new SysUser();
	 			$model->setScenario(SysUser::SCENARIO_AUTO_LOGIN);
	 			$model->user_id = $admin_user_id;
	 			$model->password = $cookies->getValue(AdminConst::COOKIE_ADMIN_PASSWORD);
	 			$user_db = null;
	 			$userService = new SysUserService();
// 	 			if($model->validate() && ($user_db = $model->login())){
	 			if($model->validate() && ($user_db = $userService->login($model))){
	 				// 	 			$_SESSION[AdminConst::LOGIN_ADMIN_USER]=$user_db;
	 				//设置用户
	 				$session->set(AdminConst::LOGIN_ADMIN_USER,$user_db);
	 				
	 				//设置权限等信息TODO:
	 			}else{
	 				//自动登陆不成功，可能是用户密码有了变更，用户被禁用；而本地存储的密码没有改变。
	 				Yii::$app->getResponse()->redirect("/merchant/system/login/index");
	 			}	
	 		}else{
	 			//redirect to 
	 			Yii::$app->getResponse()->redirect("/merchant/system/login/index");
	 		}
	 	}
	 	
		
	 	//check session for user rights(检查用户权限）
	 	
	 	
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