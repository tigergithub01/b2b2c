<?php

namespace app\modules\merchant\controllers;

use Yii;
use yii\web\Controller;
use app\modules\merchant\models\MerchantConst;
use app\modules\merchant\common\controllers\BaseAuthController;
use app\modules\merchant\service\vip\MerchantService;


/**
 * Default controller for the `merchant` module
 */
class DefaultController extends BaseAuthController
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
    	$service = new MerchantService();
    	$service->logout();
    	
    	Yii::$app->getResponse()->redirect("/merchant/system/login/index");
    }
    
}
