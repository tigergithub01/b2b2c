<?php

namespace app\modules\admin\controllers\api;


/*
 http://localhost:8089/admin/api/api-test/index
 
 
 */
class ApiTestController extends \app\modules\admin\common\controllers\BaseAuthController
{
    public function actionIndex()
    {
    	return $this->render('index');
    }

}
