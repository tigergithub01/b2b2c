<?php

namespace app\modules\admin\controllers\system;


use Yii;
use app\models\b2b2c\SysUser;
use app\modules\admin\common\controllers\BaseAuthController;
use app\modules\admin\models\AdminConst;
use app\modules\admin\service\system\SysUserService; 
use yii\helpers\Url;

class ModifyPwdController extends BaseAuthController{
	
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex()
	{
		/* service */
		$userService  = new SysUserService();
	
		/* 登陆 */
		$model = new SysUser();
		$model->setScenario(SysUser::SCENARIO_CHANGE_PWD);
// 		var_dump(Yii::$app->session->get(AdminConst::LOGIN_ADMIN_USER)->id);
		$model->id = Yii::$app->session->get(AdminConst::LOGIN_ADMIN_USER)->id;
		
		if ($model->load(Yii::$app->request->post()) && ($user_db = $userService->modify_pwd($model)) /* && $model->validate() */ /* && ($user_db = $model->login()) */) {
			if($user_db){
				//注销当前登录
				$userService->logout();
				
				//跳转到登陆页面
				Yii::$app->response->redirect(Url::toRoute(['/admin/system/login/index']));
			}
		}
			
		return $this->render('index', [
				'model' => $model,
		]);
	}
	
	
}