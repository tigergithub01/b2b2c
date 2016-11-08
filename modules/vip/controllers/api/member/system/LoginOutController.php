<?php

namespace app\modules\vip\controllers\api\member\system;

use app\common\utils\CommonUtils;
use app\models\b2b2c\common\JsonObj;
use app\modules\vip\common\controllers\BaseAuthApiController;
use app\modules\vip\service\vip\VipService;
use yii\web\Controller;

/**
 * login controller
 * @author Tiger-guo
 *
 */
class LoginOutController extends BaseAuthApiController
{
	
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex()
	{
		$json = new JsonObj();
		
		$service = new VipService();
    	$service->logout();
		
		return CommonUtils::jsonObj_success($json);
		
	}
	
	
}