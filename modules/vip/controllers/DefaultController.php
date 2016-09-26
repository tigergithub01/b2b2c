<?php

namespace app\modules\vip\controllers;

use Yii;
use yii\web\Controller;
use app\modules\vip\common\controllers\BaseController;
use yii\helpers\Url;

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
//         return $this->render('index');
    	Yii::$app->response->redirect(Url::toRoute(['/vip/member/system/login/index']));
    }
}
