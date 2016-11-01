<?php

namespace app\modules\vip\controllers\api\member\system;

use Yii;
use app\modules\vip\common\controllers\BaseAuthApiController;
use yii\helpers\Url;
use app\models\b2b2c\Vip;
use app\modules\vip\service\vip\VipService;
use app\modules\vip\models\VipConst;
use app\common\utils\CommonUtils;
use app\models\b2b2c\common\JsonObj;

class ModifyPwdController extends BaseAuthApiController{
	
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex()
	{
		/* 返回json */
		$json = new JsonObj();
		
		/* service */
		$service  = new VipService();
	
		/* 登陆 */
		$model = new Vip();
		$model->setScenario(Vip::SCENARIO_CHANGE_PWD);
// 		var_dump(Yii::$app->session->get(AdminConst::LOGIN_ADMIN_USER)->id);
		$model->id = Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
		$model->load(Yii::$app->request->post());
		if($vip_db = $service->modify_pwd($model)) {
			//注销当前登录
			$service->logout();
			
			return CommonUtils::jsonObj_success($json);
		}
			
		return CommonUtils::jsonObj_failed($json, $model);
	}
	
	
}