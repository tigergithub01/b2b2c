<?php

namespace app\modules\vip\controllers\api\member\system;

use Yii;
use app\models\b2b2c\Vip;
use yii\helpers\Url;
use app\modules\vip\common\controllers\BaseController;
use app\modules\vip\service\vip\VipService;
use app\modules\vip\models\VipConst;
use app\common\utils\CommonUtils;
use app\models\b2b2c\common\JsonObj;

class RegisterController extends BaseController
{
	
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$json = new JsonObj();
    	$service = new VipService();
    	
    	/* 登陆 */
    	$model = new Vip();
    	$model->setScenario(Vip::SCENARIO_REGISTER_NO_VERIFY);
    	$model->load(Yii::$app->request->post());
    	
    	if ($vip_db = $service->register($model)) {
    		/* $valid = $model->validate(); */
    			
//     			}else{
// 	    			/* unset($_COOKIE[AdminConst::COOKIE_ADMIN_USER_ID]);
// 	    				unset($_COOKIE[AdminConst::COOKIE_ADMIN_PASSWORD]); */
// 	    			$cookies = Yii::$app->response->cookies;
// 	    			$cookies->remove(MerchantConst::COOKIE_MERCHANT_USER_ID);
// 	    			$cookies->remove(MerchantConst::COOKIE_MERCHANT_PASSWORD);
// 	    		}
    		$json->value = ['PHPSESSID'=>Yii::$app->session->id,'vip'=>$vip_db];
    		
    		return CommonUtils::jsonObj_success($json);
	    		
	    		//登陆成功进行跳转
// 	    		Yii::$app->response->redirect(Url::toRoute(['/vip/member/default/index']));
    			
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
    
    	return CommonUtils::jsonObj_failed($json, $model);
    }
    
    
    

}
