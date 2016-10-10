<?php

namespace app\modules\vip\controllers\api\member\system;

use Yii;
use yii\web\Controller;
use app\modules\vip\common\controllers\BaseAuthController;
use app\modules\vip\service\vip\VipService;
use app\models\b2b2c\common\JsonObj;
use app\common\utils\CommonUtils;

/**
 * login controller
 * @author Tiger-guo
 *
 */
class LoginOutController extends BaseAuthController
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