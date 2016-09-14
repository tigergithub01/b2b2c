<?php

namespace app\modules\merchant\controllers\system;

use Yii;
use app\modules\merchant\common\controllers\BaseController;
use app\models\b2b2c\Vip;
use app\modules\merchant\models\MerchantConst;

class RegisterController extends BaseController
{
	public $layout = "main-login";
	
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	/* 登陆 */
    	$model = new Vip();
    	$model->setScenario(Vip::SCENARIO_LOGIN);
    
    	$user_db = null;
    	if ($model->load(Yii::$app->request->post()) && $model->validate() /* && ($user_db = $model->login()) */) {
    		/* $valid = $model->validate(); */
    		$model->password = md5($model->password);
    		if(($user_db = $model->login())){
    			//写session
    			$session = Yii::$app->session;
    			$session->set(AdminConst::LOGIN_ADMIN_USER,$user_db);
    			//写权限信息 TOOD：
    				
    				
    			//写cookie
    			if($model->remember_me){
    				//write user name into cookie
    				// 				setcookie(AdminConst::COOKIE_ADMIN_USER_ID,$user_db->user_id,time()+3600*24*7);
    				// 				setcookie(AdminConst::COOKIE_ADMIN_PASSWORD,$user_db->password,time()+3600*24*7);
    
    				$cookies = Yii::$app->response->cookies;
    				// 				$cookies->set(AdminConst::COOKIE_ADMIN_USER_ID,$user_db->user_id);
    				$cookies->add(new \yii\web\Cookie([
    						'name' => AdminConst::COOKIE_ADMIN_USER_ID,
    						'value' => $user_db->user_id,
    						'expire'=>time()+3600*24*7
    				]));
    				$cookies->add(new \yii\web\Cookie([
    						'name' => AdminConst::COOKIE_ADMIN_PASSWORD,
    						'value' => $user_db->password,
    						'expire'=>time()+3600*24*7
    				]));
    			}
    		}else{
    			/* unset($_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID]);
    				unset($_COOKIE[AdminConst::COOKIE_ADMIN_PASSWORD]); */
    
    			$cookies = Yii::$app->response->cookies;
    			$cookies->remove(AdminConst::COOKIE_ADMIN_USER_ID);
    			$cookies->remove(AdminConst::COOKIE_ADMIN_PASSWORD);
    		}
    			
    		// 			if($valid){
    		Yii::$app->response->redirect("/admin/default/index");
    		// 			}
    		// 			return $this->goBack();
    	}
    	/* return $this->renderPartial('login', [
    	 'model' => $model,
    	]); */
    
    
    	/* return $this->renderAjax('login', [
    	 'model' => $model,
    	]); */
    
    
    	return $this->render('index', [
    			'model' => $model,
    	]);
    
    }

}
