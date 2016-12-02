<?php

namespace app\modules\vip\controllers\api\system;

use app\common\utils\CommonUtils;
use app\models\b2b2c\common\JsonObj;
use app\models\b2b2c\SysConfig;
use app\modules\vip\common\controllers\BaseApiController;
use yii\helpers\Json;

/**
 * SysConfigController implements the CRUD actions for SysConfig model.
 */
class SysConfigController extends BaseApiController
{
    public function actionViewServiceTel()
    {
    	$json = new JsonObj();
    	$model = SysConfig::find()->where(['code'=>'service_tel'])->one();
    	if(empty($model)){
    		return CommonUtils::json_failed("您要查找的数据不存在！");
    	}
    	return CommonUtils::json_success($model->value);
    }
}
