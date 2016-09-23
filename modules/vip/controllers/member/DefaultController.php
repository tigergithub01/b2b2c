<?php

namespace app\modules\vip\controllers\member;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\modules\vip\common\controllers\BaseAuthController;

/**
 * Default controller for the `vip` module
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
}
