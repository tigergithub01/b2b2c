<?php

namespace app\modules\vip\controllers\api\member\system;

use Yii;
use yii\web\Controller;
use app\models\b2b2c\Vip;
use app\modules\vip\common\controllers\BaseApiController;
use app\modules\vip\service\vip\VipService;
use app\modules\vip\models\VipConst;
use app\models\b2b2c\common\JsonObj;
use app\common\utils\CommonUtils;
use yii\helpers\Json;
use app\common\utils\AuthUtils;
use app\common\utils\UrlUtils;

/**
 * login controller
 * @author Tiger-guo
 *
 */
class LoginController extends BaseApiController
{
	
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex()
	{
		$json = new JsonObj();
		$service = new VipService();
		
		/* 登陆 */
		$model = new Vip();
		$model->setScenario(Vip::SCENARIO_LOGIN_NO_VERIFY);
		$model->load(Yii::$app->request->post());
					
		if (($vip_db = $service->login($model))) {
			//登陆成功后根据情况进行跳转
			$last_access_url = Yii::$app->session->get(VipConst::VIP_LAST_ACCESS_URL);
			if($last_access_url){
				Yii::$app->session->remove(VipConst::VIP_LAST_ACCESS_URL);
// 				Yii::$app->response->redirect($last_access_url);
			}else{
// 				Yii::$app->response->redirect("/vip/member/default/index");
			}
			
			//产生加密字符
			$uid = $vip_db->id;
			$time = time();
			$key = md5($uid + $time+"secret_key_hl");
			
			$authUtils =  new AuthUtils(); 
			$auth = $authUtils->getAuthKey($vip_db->id);
			
			//format urls
			$vip_db->img_url = UrlUtils::formatUrl($vip_db->img_url);
			$vip_db->thumb_url = UrlUtils::formatUrl($vip_db->thumb_url);
			$vip_db->img_original = UrlUtils::formatUrl($vip_db->img_original);
			
			$json->value = ['last_access_url'=>$last_access_url,
					'PHPSESSID'=>Yii::$app->session->id,
					'vip'=>$vip_db, 
					'app_uid'=> $auth['uid'],
					'app_time'=> $auth['time'],
					'app_key' => $auth['key'],
			];
			
			return CommonUtils::jsonObj_success($json);
		}
		
		/* 输出错误  */
// 		return $this->render("@app/modules//vip/views/api/index", [
// 				'model' => $model,
// 		]);
		
		return CommonUtils::jsonObj_failed($json, $model);
		
	}
	
	
	/* 找回密码  */
	public function actionForgotPwd(){
		$json = new JsonObj();
		$service = new VipService();
		
		/* 登陆 */
		$model = new Vip();
		$model->setScenario(Vip::SCENARIO_FORGOT_PWD_NO_VERIFY);
		$model->load(Yii::$app->request->post());
		
		if ($vip_db = $service->forgot_pwd($model)) {
			/* $valid = $model->validate(); */
// 			$model->password = md5($model->password);
			/* if(($vip_db = $merchantService->login($model))){ */
				//找回密码成功后，跳转到登陆页面
// 				Yii::$app->response->redirect(Url::toRoute(['/vip/member/system/login/index']));
				return CommonUtils::jsonObj_success($json);
			// 			return $this->goBack();
		}
		
		return CommonUtils::jsonObj_failed($json, $model); 
	}
}