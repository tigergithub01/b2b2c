<?php
namespace app\modules\admin\common\filters;

use Yii;
use yii\base\ActionFilter;

class AdminLogFilter extends ActionFilter{
	
	public function init(){
		parent::init();
	}
	
	public function beforeAction($action){
		//TODO:
// 		var_dump($action);
		Yii::info('AdminLogFilter beforeAction ');
// 		Yii::$app->getSession()->get($key)
// 		Yii::$app->getRequest()->get($key);
// 		Yii::$app->response->redirect("/site/index");
// 		return true;		
// 		Yii::$app->controller->layout='@app/views/layouts/manager.php';
		return parent::beforeAction($action);
	}
	
	public function afterAction($action, $result){
		//TODO:
		Yii::info('AdminLogFilter afterAction ');
		return parent::afterAction($action, $result);
	}
	
}