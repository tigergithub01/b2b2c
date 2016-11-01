<?php

namespace app\modules\vip\controllers\api\system;


use Yii;
use app\modules\vip\common\controllers\BaseApiController;
use app\models\b2b2c\SysAdInfo;
use app\models\b2b2c\common\JsonObj;
use yii\helpers\Json;
use app\common\utils\UrlUtils;
use app\models\b2b2c\app\models\b2b2c;
use app\common\utils\CommonUtils;

/*
 	http://localhost:8089/vip/api/system/sys-ad-info/index
 	广告图
 */
class SysAdInfoController extends BaseApiController
{
    public function actionIndex()
    {
    	$json = new JsonObj();
    	$list = SysAdInfo::find()->orderBy(['sequence_id'=>SORT_ASC])->all();
    	/*  格式化URL输出 */
    	foreach ($list as $value) {
    		$value->img_url = UrlUtils::formatUrl($value->img_url);
    		$value->thumb_url = UrlUtils::formatUrl($value->thumb_url);
    		$value->img_original = UrlUtils::formatUrl($value->img_original);
    	}
    	return CommonUtils::json_success($list);
    }

}
