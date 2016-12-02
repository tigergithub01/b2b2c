<?php
namespace app\modules\vip\common\filters;

use app\common\utils\AuthUtils;
use app\common\utils\CommonUtils;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\Vip;
use app\modules\vip\models\VipConst;
use Yii;
use yii\base\ActionFilter;
use yii\helpers\Url;
use app\common\utils\UrlUtils;

class VipAuthApiFilter extends ActionFilter{
	
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
		
		//获取客户端传过来的值
// 		$app_uid = Yii::$app->request->post("app_uid");
// 		$app_time = Yii::$app->request->post("app_time");
// 		$app_key = Yii::$app->request->post("app_key");
		
		$app_uid = isset($_REQUEST['app_uid'])?$_REQUEST['app_uid']:null;
		$app_time = isset($_REQUEST['app_time'])?$_REQUEST['app_time']:null;
		$app_key = isset($_REQUEST['app_key'])?$_REQUEST['app_key']:null;
		
		
		if(empty($app_uid)){
			CommonUtils::response_failed("app_uid不能为空！");
			return false;
		}
		
		if(empty($app_time)){
			CommonUtils::response_failed("app_time不能为空！");
			return false;
		}
		
		if(empty($app_key)){
			CommonUtils::response_failed("app_key不能为空！");
			return false;
		}
		
		$authUtils = new AuthUtils();
		if(!($authUtils->verifyKey($app_uid, $app_time, $app_key))){
			CommonUtils::response_failed("app_key验证不成功！");
			return false;
		}
		
		$vip_db = Vip::findOne($app_uid);
		if(empty($vip_db)){
			CommonUtils::response_failed("用户不存在！");
			$session->set(VipConst::VIP_LAST_ACCESS_URL,Yii::$app->request->url);
			return false;
		}
		
		//判断用户是否有效
		if($vip_db->status==SysParameter::no){
			CommonUtils::response_failed("该用户已停用！");
			return false;
		}
		
		//format urls
		$vip_db->img_url = UrlUtils::formatUrl($vip_db->img_url);
		$vip_db->thumb_url = UrlUtils::formatUrl($vip_db->thumb_url);
		$vip_db->img_original = UrlUtils::formatUrl($vip_db->img_original);
		
		//设置当前session
		$session->set(VipConst::LOGIN_VIP_USER,$vip_db->getWebVip()); //设置当前登录用户		
		
		//设置cookie
		$cookies = Yii::$app->response->cookies;
		$cookies->add(new \yii\web\Cookie([
				'name' => VipConst::COOKIE_VIP_USER_ID,
				'value' => $vip_db->vip_id,
				'expire'=>time()+3600*24*7
		]));
		$cookies->add(new \yii\web\Cookie([
				'name' => VipConst::COOKIE_VIP_PASSWORD,
				'value' => $vip_db->password,
				'expire'=>time()+3600*24*7
		]));
		
		return parent::beforeAction($action);
	}
	
	public function afterAction($action, $result){
		return parent::afterAction($action, $result);
	}
	
}