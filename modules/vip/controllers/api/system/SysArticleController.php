<?php

namespace app\modules\vip\controllers\api\system;


use app\common\utils\CommonUtils;
use app\models\b2b2c\common\JsonObj;
use app\models\b2b2c\SysArticle;
use app\modules\vip\common\controllers\BaseApiController;
use yii\helpers\Json;

/*
 	http://localhost:8089/vip/api/system/sys-article/view
 	用户协议
 */
class SysArticleController extends BaseApiController
{
    public function actionView()
    {
    	$json = new JsonObj();
    	$model = SysArticle::find()->where(['code'=>'register_agreement'])->one();
    	return CommonUtils::json_success($model);
    }

}
