<?php

namespace app\modules\vip\controllers\member\system;

use Yii;
use app\models\b2b2c\Vip;
use yii\helpers\Url;
use app\modules\vip\common\controllers\BaseController;
use app\modules\vip\service\vip\VipService;
use app\modules\vip\models\VipConst;

class RegisterController extends BaseController
{
	public $layout = "main-login";
	
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	//test
    	$smsUtils = new \app\common\utils\sms\SmsUtils();
    	$sms_code = $smsUtils->random(6, 1);
    	$smsUtils->sendSms("13724346621", $sms_code);
    	
    	$service = new VipService();
    	
    	/* 登陆 */
    	$model = new Vip();
    	$model->setScenario(Vip::SCENARIO_REGISTER);
    	
//     	var_dump(Yii::$aliases);
// 		var_dump(Yii::$app->session);
// 		var_dump(time());
// 		var_dump(strtotime(date('Y-m-d H:i:s',time())));
// 		var_dump(date('Y-m-d 23:59:59',time()));
    
    	if ($model->load(Yii::$app->request->post()) && ($vip_db = $service->register($model)) /* && $model->validate()  *//* && ($user_db = $model->login()) */) {
    		/* $valid = $model->validate(); */
    		if($vip_db){
    			//写session
    			$session = Yii::$app->session;
    			$session->set(VipConst::LOGIN_VIP_USER,$vip_db);
    			//写权限信息 TOOD：
    				
    				
    			//写cookie
//     			if($model->remember_me){
    				//write user name into cookie
    				// 				setcookie(AdminConst::COOKIE_ADMIN_USER_ID,$user_db->user_id,time()+3600*24*7);
    				// 				setcookie(AdminConst::COOKIE_ADMIN_PASSWORD,$user_db->password,time()+3600*24*7);
    
    				$cookies = Yii::$app->response->cookies;
    				// 				$cookies->set(AdminConst::COOKIE_ADMIN_USER_ID,$user_db->user_id);
    				$cookies->add(new \yii\web\Cookie([
    						'name' => VipConst::COOKIE_VIP_USER_ID,
    						'value' => $vip_db->vip_id,
    						'expire'=>time()+3600*24*7
    				]));
    				$cookies->add(new \yii\web\Cookie([
    						'name' => VipConst::COOKIE_VIP_PASSWORD,
    						'value' => $vip_db->password,
    						'expire'=>time()+3600*24*7
    				]));
//     			}else{
// 	    			/* unset($_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID]);
// 	    				unset($_COOKIE[AdminConst::COOKIE_ADMIN_PASSWORD]); */
// 	    			$cookies = Yii::$app->response->cookies;
// 	    			$cookies->remove(MerchantConst::COOKIE_MERCHANT_USER_ID);
// 	    			$cookies->remove(MerchantConst::COOKIE_MERCHANT_PASSWORD);
// 	    		}
	    		
	    		//登陆成功进行跳转
	    		Yii::$app->response->redirect(Url::toRoute(['/vip/member/default/index']));
    		}
    			
    		// 			if($valid){
    		
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
