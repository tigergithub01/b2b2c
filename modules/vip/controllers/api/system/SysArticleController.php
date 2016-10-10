<?php

namespace app\modules\vip\controllers\api\system;


use Yii;
use app\modules\vip\common\controllers\BaseController;
use app\models\b2b2c\common\JsonObj;
use yii\helpers\Json;
use app\common\utils\UrlUtils;
use app\models\b2b2c\app\models\b2b2c;
use app\common\utils\CommonUtils;
use app\models\b2b2c\SysArticle;

/*
 	http://localhost:8089/vip/api/system/sys-article/view
 	用户协议
 */
class SysArticleController extends BaseController
{
    public function actionView()
    {
    	$json = new JsonObj();
    	$model = SysArticle::find()->where(['code'=>'register_agreement'])->one();
    	return CommonUtils::json_success($model);
    }

}
