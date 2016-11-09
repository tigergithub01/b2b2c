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
	
	
	/**
	 *  1：客户端输入用户名和密码，提交到服务端验证

		2：服务端验证成功后，给客户端返回以下值：
		
		uid : 用户的唯一标示
		
		time : 当前unix时间戳
		
		key : MD5(uid+time+"一个只有你自己知道的字符串密钥")
		
		3：客户端保存以上3个值在本地，每次HTTP请求时，将以上3个值发送到服务端
		
		4：服务端验证key，判断如果与客户端发送的key一致，则说明用户身份无误
		
		5：服务端每次收到请求时，通过当前时间-客户端time字段得到的差值，可以控制这个key的有效期
	 * {@inheritDoc}
	 * @see \yii\base\ActionFilter::beforeAction()
	 */
	public function beforeAction($action){
		//通过客户端传过来的值来验证是否是正常用户，如果是正常用户，直接写session
		
		
		
		
		
		
		
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
					$session->set(VipConst::LOGIN_VIP_USER,$vip_db->getWebVip());
		
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