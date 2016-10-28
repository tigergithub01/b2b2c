<?php
namespace app\modules\admin\common\filters;

use Yii;
use yii\base\ActionFilter;
use app\models\b2b2c\SysOperationLog;
use app\modules\admin\models\AdminConst;

class AdminLogFilter extends ActionFilter{
	
	public function init(){
		parent::init();
	}
	
	public function beforeAction($action){
		return parent::beforeAction($action);
	}
	
	public function afterAction($action, $result){
		return parent::afterAction($action, $result);
	}
	
}