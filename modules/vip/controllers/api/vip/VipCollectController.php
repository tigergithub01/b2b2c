<?php

namespace app\modules\vip\controllers\api\vip;

use app\common\utils\CommonUtils;
use app\models\b2b2c\VipCollect;
use app\modules\vip\common\controllers\BaseApiController;
use app\modules\vip\service\vip\VipCollectService;

/**
 * VipCollectController implements the CRUD actions for VipCollect model.
 */
class VipCollectController extends BaseApiController
{
    
    /**
     * 获取收藏的数量
     * @param string $id
     * @return mixed
     */
    public function actionCount()
    {
    	$ref_id = isset($_REQUEST['ref_id'])?$_REQUEST['ref_id']:null; //关联收藏对象编号
    	$collect_type = isset($_REQUEST['collect_type'])?$_REQUEST['collect_type']:null; //收藏类型
    	
    	if(empty($ref_id)){
    		return CommonUtils::json_failed("编号不能为空");
    	}
    	 
    	if(empty($collect_type)){
    		return CommonUtils::json_failed("取消收藏类型不能为空");
    	}
    	
    	$vipCollectService = new VipCollectService();
    	$count = $vipCollectService->getVipCollectCount($collect_type, $ref_id);
    	 
    	return CommonUtils::json_success($count);
    }
    
    
}
