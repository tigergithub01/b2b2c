<?php

namespace app\modules\vip\controllers\system;

use app\common\utils\CommonUtils;
use app\models\b2b2c\SysAppInfo;
use app\models\b2b2c\SysAppRelease;
use app\modules\vip\common\controllers\BaseController;
use Yii;


/* 
 
 app下载
 http://localhost:8089/vip/system/sys-app-info/index?code=wedding_android
 */
class SysAppInfoController extends BaseController
{
	
    public function actionIndex()
    {
    	$request = Yii::$app->request;
    	
    	//根据code下载
    	$code = isset($_REQUEST['code'])?$_REQUEST['code']:null;
    	if($code){
    		$sysAppInfo = SysAppInfo::find()->where('code=:code',['code'=>$code])->one();
    	}else{
    		$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
    		$sysAppInfo = SysAppInfo::findOne ( $id );
    	}
    	
    	if(empty($sysAppInfo)){
    		CommonUtils::response_failed(Yii::t('app', '您要下载的文件不存在。'));
    		return;
    	}   
    	
    	$appRelease = SysAppRelease::find()->where(['app_info_id' => $sysAppInfo->id,])->orderBy(['ver_no' => SORT_DESC])->one();
    	$file_path = Yii::getAlias("@webroot").'/'.$appRelease->app_path;
    	$file_name  = $sysAppInfo->name . $appRelease->name . '.apk';
    	header ( "Content-type:text/html;charset=utf-8" );
    	// 用以解决中文不能显示出来的问题
    	$file_name = iconv ( "utf-8", "gb2312", $file_name );
    	// 		echo $file_path;
    	// 首先要判断给定的文件存在与否
    	if (! file_exists ( $file_path )) {
    		CommonUtils::response_failed(Yii::t('app', '您要下载的文件不存在。'));
    		return;
    	}
    	$fp = fopen ( $file_path, "r" );
    	$file_size = filesize ( $file_path );
    	// 下载文件需要用到的头
    	Header ( "Content-type: application/octet-stream" );
    	Header ( "Accept-Ranges: bytes" );
    	Header ( "Accept-Length:" . $file_size );
    	Header ( "Content-Disposition: attachment; filename=" . $file_name );
    	$buffer = 1024;
    	$file_count = 0;
    	// 向浏览器返回数据
    	while ( ! feof ( $fp ) && $file_count < $file_size ) {
    		$file_con = fread ( $fp, $buffer );
    		$file_count += $buffer;
    		echo $file_con;
    	}
    	fclose ( $fp );
    	
    	
    	// 		return $this->render ( 'index' );
//         return $this->render('index');
    }

}
