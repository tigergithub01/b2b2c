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
			
			$json->value = ['last_access_url'=>$last_access_url,'PHPSESSID'=>Yii::$app->session->id,'vip'=>$vip_db];
			
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