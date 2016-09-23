<?php

namespace app\modules\merchant\controllers\member\system;

use Yii;
use app\modules\merchant\common\controllers\BaseAuthController;
use app\modules\merchant\models\MerchantConst;
use app\modules\merchant\service\vip\MerchantService;
use yii\helpers\Url;
use app\models\b2b2c\Vip;

class ModifyPwdController extends BaseAuthController{
	
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex()
	{
		/* service */
		$service  = new MerchantService();
	
		/* 登陆 */
		$model = new Vip();
		$model->setScenario(Vip::SCENARIO_CHANGE_PWD);
// 		var_dump(Yii::$app->session->get(AdminConst::LOGIN_ADMIN_USER)->id);
		$model->id = Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
		
		if ($model->load(Yii::$app->request->post()) && ($vip_db = $service->modify_pwd($model)) /* && $model->validate() */ /* && ($user_db = $model->login()) */) {
			if($vip_db){
				//注销当前登录
				$service->logout();
				
				//跳转到登陆页面
				Yii::$app->response->redirect(Url::toRoute(['/merchant/system/login/index']));
			}
		}
			
		return $this->render('index', [
				'model' => $model,
		]);
	}
	
	
}