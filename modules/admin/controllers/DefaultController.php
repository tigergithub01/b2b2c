<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\modules\admin\common\controllers\BaseAuthController;
use app\modules\admin\models\AdminConst;
use app\modules\admin\service\system\SysUserService;

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
    
    /**
     * 注销
     */
    public function actionLogout()
    {
    	$userService = new SysUserService();
    	$userService->logout();
    	
    	Yii::$app->getResponse()->redirect("/admin/system/login/index");
    }
}
