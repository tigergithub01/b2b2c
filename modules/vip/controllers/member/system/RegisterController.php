<?php

namespace app\modules\vip\controllers\member\system;

use Yii;
use app\models\b2b2c\Vip;
use yii\helpers\Url;
use app\modules\vip\common\controllers\BaseController;
use app\modules\vip\service\vip\VipService;

class RegisterController extends BaseController
{
	public $layout = "main-login";
	
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
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
    			
//     			}else{
// 	    			/* unset($_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID]);
// 	    				unset($_COOKIE[AdminConst::COOKIE_ADMIN_PASSWORD]); */
// 	    			$cookies = Yii::$app->response->cookies;
// 	    			$cookies->remove(MerchantConst::COOKIE_MERCHANT_USER_ID);
// 	    			$cookies->remove(MerchantConst::COOKIE_MERCHANT_PASSWORD);
// 	    		}
	    		
	    		//登陆成功进行跳转
	    		Yii::$app->response->redirect(Url::toRoute(['/vip/member/default/index']));
    			
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
    	//还原密码，因为验证不通过时，password已经被md5加密
    	$model->password = $model->confirm_pwd;
    
    	return $this->render('index', [
    			'model' => $model,
    	]);
    
    }
    
    
    

}
