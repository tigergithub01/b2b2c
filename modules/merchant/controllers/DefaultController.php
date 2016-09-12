<?php

namespace app\modules\merchant\controllers;

use Yii;
use yii\web\Controller;
use app\modules\merchant\models\MerchantConst;

/**
 * Default controller for the `merchant` module
 */
class DefaultController extends Controller
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
    	
    	Yii::$app->getResponse()->redirect("/merchant/system/login/index");
    }
    
}
