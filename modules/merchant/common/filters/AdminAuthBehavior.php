<?php
namespace app\modules\merchant\common\filters;

use Yii;
use yii\base\Behavior;;
use yii\web\Controller;

class AdminAuthBehavior extends Behavior{
	
	public function events()
	{
		return [Controller::EVENT_BEFORE_ACTION => 'beforeAction',
				Controller::EVENT_AFTER_ACTION=>'afterAction'];
	}
	
	
	 public function beforeAction($event){
// 	 	var_dump("xxx");
	 	Yii::info('AdminAuthBehavior beforeAction' );
	 	
	 	//check cookie for auto login
// 	 	Yii::$app->request->cookies;
		
	 	//check session for user rights
// 	 	Yii::$app->session;	 	
	 	
// 	 	Yii::$app->getResponse()->redirect("\admin\default\login");
	 }
	 
	 public function afterAction($event){
	 	//TODO:
	 	Yii::info('AdminAuthBehavior afterAction ');
	 }
	
	/* public function beforeAction($action){
		parent::
		//TODO:
		//var_dump($action);
		Yii::info('AdminAuthBehavior beforeAction ' );
// 		Yii::$app->getSession()->get($key)
// 		Yii::$app->getRequest()->get($key);
// 		Yii::$app->response->redirect("/site/index");
// 		return true;		
// 		Yii::$app->controller->layout='@app/views/layouts/manager.php';
		return parent::beforeAction($action);
	}
	
	public function afterAction($action, $result){
		//TODO:
		Yii::info('AdminAuthBehavior afterAction ');
		return parent::afterAction($action, $result);
	}
	 */
}