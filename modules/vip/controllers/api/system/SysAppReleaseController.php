<?php

namespace app\modules\vip\controllers\api\system;

use Yii;
use app\modules\vip\common\controllers\BaseApiController;
use app\models\b2b2c\SysAppInfo;
use app\models\b2b2c\common\JsonObj;
use app\models\b2b2c\SysAppRelease;
use app\common\utils\CommonUtils;
use app\common\utils\UrlUtils;


/* 
 
 app下载
 http://localhost:8089/vip/api/system/sys-app-release/index?code=wedding_android
 */
class SysAppReleaseController extends BaseApiController
{
	
    public function actionIndex()
    {
    	$request = Yii::$app->request;
    	
    	//根据code查询最新版
    	$code = isset($_REQUEST['code'])?$_REQUEST['code']:null;
    	if($code){
    		$sysAppInfo = SysAppInfo::find()->where('code=:code',['code'=>$code])->one();
    	}else{
    		$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
    		$sysAppInfo = SysAppInfo::findOne ( $id );
    	}
    	
    	if(empty($sysAppInfo)){
    		return CommonUtils::json_failed(Yii::t('app', '版本编码不能为空！'));
    	}   
		
    	if(empty($sysAppInfo->release_id)){
    		return CommonUtils::json_failed(Yii::t('app', '版本信息不存在！'));
    		
    	}
    	
    	$appRelease = SysAppRelease::findOne($sysAppInfo->release_id);
    	
    	//格式化下载地址
    	$appRelease->app_path = UrlUtils::formatUrl($appRelease->app_path);
    	
    	
    	return CommonUtils::json_success($appRelease);
    	
    	
    	// 		return $this->render ( 'index' );
//         return $this->render('index');
    }

}
