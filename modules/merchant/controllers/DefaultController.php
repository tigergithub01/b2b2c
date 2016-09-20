<?php

namespace app\modules\merchant\controllers;

use Yii;
use yii\web\Controller;
use app\modules\merchant\models\MerchantConst;
use app\modules\merchant\common\controllers\BaseAuthController;

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
    
    
    public function actionLogout()
    {
    	//clear session
    	$session = Yii::$app->session;
    	unset($session[MerchantConst::LOGIN_MERCHANT_USER]);    	
    	
    	//clear cookie
    	$cookies = Yii::$app->request->cookies;
    	if(isset($cookies[MerchantConst::COOKIE_MERCHANT_USER_ID])){
	    	Yii::$app->response->cookies->remove(MerchantConst::COOKIE_MERCHANT_USER_ID);
	    	Yii::$app->response->cookies->remove(MerchantConst::COOKIE_MERCHANT_PASSWORD);
// 	    	unset(Yii::$app->response->cookies[MerchantConst::COOKIE_ADMIN_USER_ID]);
    	}
//     	unset($_COOKIE[MerchantConst::COOKIE_ADMIN_USER_ID]);

    	//清空最后一次访问链接
    	$session->remove(MerchantConst::MERCHANT_LAST_ACCESS_URL);
    	
    	Yii::$app->getResponse()->redirect("/merchant/system/login/index");
    }
    
}
