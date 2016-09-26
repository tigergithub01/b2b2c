<?php

namespace app\modules\vip\controllers\member;

use Yii;
use yii\web\Controller;
use app\modules\vip\common\controllers\BaseController;
use yii\helpers\Url;
use app\modules\vip\service\vip\VipService;

/**
 * Default controller for the `vip` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * 注销
     */
    public function actionLogout()
    {
    	$service = new VipService();
    	$service->logout();
    	 
    	Yii::$app->getResponse()->redirect("/vip/member/system/login/index");
    }
}
