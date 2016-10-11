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
use app\models\b2b2c\SysRegion;
use app\models\b2b2c\VipOrganization;


class SysRegionController extends BaseController
{
    
	/*
	 http://localhost:8089/vip/api/system/sys-region/index
	 http://localhost:8089/vip/api/system/sys-region/index?region_type=22003&parent_id=48543
	 区域信息
	 */
	public function actionIndex()
    {
    	//区域类型
    	$region_type = isset($_REQUEST['region_type'])?$_REQUEST['region_type']:null;
    	$parent_id = isset($_REQUEST['parent_id'])?$_REQUEST['parent_id']:null;
    	
    	$region_list = SysRegion::find()->alias('reg')->joinWith('parent p')->joinWith('regionType t')
    		->andFilterWhere([
    			'reg.parent_id' => $parent_id,
    			'reg.region_type' => $region_type,
    	])->limit(1000)->all();
    	
    	return CommonUtils::json_success($region_list);
    }
    
    /**
     * 获取商家所在的所有城市列表
     * http://localhost:8089/vip/api/system/sys-region/merchant-regions
     * @return string
     */
    public function actionMerchantRegions()
    {
    	$region_list = VipOrganization::find()->select(['c.*'])->innerJoinWith('city c')->distinct()->all();
    	return CommonUtils::json_success($region_list);
    }

}
