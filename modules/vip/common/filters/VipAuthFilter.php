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
					}else{
						Yii::$app->getResponse()->redirect(Url::toRoute(['/vip/member/system/login/index']));
					}
					return false;
				}
			}else{
				//redirect to
				if (Yii::$app->getRequest()->getIsAjax()) {
					CommonUtils::response_failed("请先登陆。", Constant::err_code_no_login);
				}else{
					Yii::$app->getResponse()->redirect(Url::toRoute(['/vip/member/system/login/index']));
				}
				return false;
			}
			}
		return parent::beforeAction($action);
	}
	
	public function afterAction($action, $result){
		return parent::afterAction($action, $result);
	}
	
}