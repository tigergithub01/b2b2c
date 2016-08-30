<?php

namespace app\modules\merchant\controllers;

use Yii;
use yii\web\Controller;

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
    	Yii::$app->getResponse()->redirect("/merchant/common/login/index");
    	/* Yii::$app->user->logout();
    
    	return $this->goHome(); */
    }
    
}
