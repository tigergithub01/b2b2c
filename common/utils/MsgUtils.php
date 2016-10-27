<?php
namespace app\common\utils;

use Yii;

class MsgUtils{
	
	public static function success($msg = '操作成功.'){
		\Yii::$app->getSession()->setFlash('success', $msg);
	}
	
	public static function error($msg = '操作失败.'){
		\Yii::$app->getSession()->setFlash('warning', $msg);
	}
	
	public static function info($msg = ''){
		\Yii::$app->getSession()->setFlash('info', $msg);
	}
	
	public static function warning($msg = ''){
		\Yii::$app->getSession()->setFlash('warning', $msg);
	}
	
}