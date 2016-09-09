<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\modules\admin\common\controllers\BaseAuthController;
use app\modules\admin\models\AdminConst;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends BaseAuthController
{
// 	public $layout = "main-default";
	public $layout = "main";
    
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
    	unset($session[AdminConst::LOGIN_ADMIN_USER]);    	
    	
    	//clear cookie
    	$cookies = Yii::$app->request->cookies;
    	if(isset($cookies[AdminConst::COOKIE_ADMIN_USER_ID])){
	    	Yii::$app->response->cookies->remove(AdminConst::COOKIE_ADMIN_USER_ID);
	    	Yii::$app->response->cookies->remove(AdminConst::COOKIE_ADMIN_PASSWORD);
// 	    	unset(Yii::$app->response->cookies[AdminConst::COOKIE_ADMIN_USER_ID]);
    	}
//     	unset($_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID]);
    	
    	Yii::$app->getResponse()->redirect("/admin/system/login/index");
    }
}
