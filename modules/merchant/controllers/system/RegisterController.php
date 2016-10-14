<?php

namespace app\modules\merchant\controllers\system;

use Yii;
use app\modules\merchant\common\controllers\BaseController;
use app\models\b2b2c\Vip;
use app\modules\merchant\models\MerchantConst;
use app\modules\merchant\service\vip\MerchantService;
use yii\helpers\Url;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\VipType;
use app\models\b2b2c\SysParameter;

class RegisterController extends BaseController
{
	public $layout = "main-login";
	
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$merchantService = new MerchantService();
    	
    	/* 注册 */
    	$model = new Vip();
    	$model->setScenario(Vip::SCENARIO_MERCHANT_REGISTER);
    	
//     	var_dump(Yii::$aliases);
// 		var_dump(Yii::$app->session);
// 		var_dump(time());
// 		var_dump(strtotime(date('Y-m-d H:i:s',time())));
// 		var_dump(date('Y-m-d 23:59:59',time()));
    
    	if ($model->load(Yii::$app->request->post()) && ($vip_db = $merchantService->register($model)) /* && $model->validate()  *//* && ($user_db = $model->login()) */) {
    		/* $valid = $model->validate(); */
    			//写session
    			
//     			}else{
// 	    			/* unset($_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID]);
// 	    				unset($_COOKIE[AdminConst::COOKIE_ADMIN_PASSWORD]); */
// 	    			$cookies = Yii::$app->response->cookies;
// 	    			$cookies->remove(MerchantConst::COOKIE_MERCHANT_USER_ID);
// 	    			$cookies->remove(MerchantConst::COOKIE_MERCHANT_PASSWORD);
// 	    		}
	    		
	    		//登陆成功进行跳转
	    		Yii::$app->response->redirect(Url::toRoute(['/merchant/default/index']));
    			
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
    			'vipTypes' => VipType::find()->where(['merchant_flag'=>SysParameter::yes])->all(),
    	]);
    
    }
    
    
    

}
