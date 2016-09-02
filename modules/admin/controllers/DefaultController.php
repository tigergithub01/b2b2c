<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\modules\admin\common\controllers\BaseAuthController;

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
    	Yii::$app->getResponse()->redirect("/admin/system/login/index");
    	/* Yii::$app->user->logout();
    
    	return $this->goHome(); */
    }
}
