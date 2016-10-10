<?php
namespace app\modules\vip\common\filters;

use Yii;
use yii\base\Behavior;;
use yii\web\Controller;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\Vip;
use yii\helpers\Url;
use app\modules\vip\models\VipConst;
use app\common\utils\CommonUtils;
use app\models\b2b2c\common\Constant;

class VipAuthBehavior extends Behavior{
	
	public function events()
	{
		return [Controller::EVENT_BEFORE_ACTION => 'beforeAction',
				Controller::EVENT_AFTER_ACTION=>'afterAction'];
	}
	
	
	 public function beforeAction($event){
	 	//check cookie for auto login
// 	 	Yii::$app->request->cookies;
	 	$session = Yii::$app->session;
	 	$login_vip = $session->get(VipConst::LOGIN_VIP_USER);
	 	$cookies = Yii::$app->request->cookies;
	 	$merchant_user_id = $cookies->getValue(VipConst::COOKIE_VIP_USER_ID);
// 	 	$admin_user_id = $_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID];
// 	 	$admin_user_id = $cookies[AdminConst::COOKIE_ADMIN_USER_ID]->value;
	 	if(empty($login_vip)){
	 		//记录最后次访问URL
	 		$session->set(VipConst::VIP_LAST_ACCESS_URL,Yii::$app->request->url);
	 		
	 		//是否自动登陆
	 		if($merchant_user_id){
	 			//auto login
	 			$model = new Vip();
	 			$model->setScenario(Vip::SCENARIO_AUTO_LOGIN);
	 			$model->vip_id = $merchant_user_id;
	 			$model->password = $cookies->getValue(VipConst::COOKIE_VIP_PASSWORD);
	 			$merchantService = new MerchantService();
// 	 			if($model->validate() && ($user_db = $model->login())){
	 			if($model->validate() && ($vip_db = $merchantService->login($model,true))){
	 				// 	 			$_SESSION[AdminConst::LOGIN_ADMIN_USER]=$user_db;
	 				//设置用户
	 				$session->set(VipConst::LOGIN_VIP_USER,$vip_db);
	 				
	 				//设置权限等信息TODO:
	 				
	 				
	 			}else{
	 				//自动登陆不成功，可能是用户密码有了变更，用户被禁用；而本地存储的密码没有改变。
	 				if (Yii::$app->getRequest()->getIsAjax()) {
	 					CommonUtils::response_failed("请先登陆。", Constant::err_code_no_login);
	 				}else{
	 					Yii::$app->getResponse()->redirect(Url::toRoute(['/vip/member/system/login/index']));
// 	 					exit;
	 				}
	 			}	
	 		}else{
	 			//redirect to 
	 			if (Yii::$app->getRequest()->getIsAjax()) {
	 				CommonUtils::response_failed("请先登陆。", Constant::err_code_no_login);
	 			}else{
	 				Yii::$app->getResponse()->redirect(Url::toRoute(['/vip/member/system/login/index']));
// 	 				exit;
	 			}
	 			
// 	 			
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