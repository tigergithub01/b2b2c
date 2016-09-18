<?php

namespace app\modules\merchant\controllers\system;

use Yii;
use yii\filters\AccessControl;
use app\modules\merchant\common\controllers\BaseController;
use app\modules\merchant\models\MerchantConst;
use yii\helpers\Json;
use app\models\b2b2c\SysParameter;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\common\JsonObj;

/**
 * 获取短信验证码
 * 
 * @author Tiger-guo
 *        
 */
class SmsController extends BaseController {
	public $layout = "main-login";	
	
	/* public function behaviors() {
		return array_merge ( [ 
				'access' => [ 
						'class' => AccessControl::className (),
						'only' => ['logout'],
						'rules' => [ 
								[ 
										'actions' => [ 
												'logout' 
										],
										'allow' => true 
								] 
						] 
				] 
		], parent::behaviors () );
	} */
	
	/**
	 * Renders the index view for the module
	 * 
	 * @return string
	 */
	public function actionIndex() {
		$json = new JsonObj();
		$json->status = false;
				
		//手机号码是否为空
		
		//图形验证码是否为空
		

		//图形验证码是否正确
		
		
		
		
		//根据数据库判断验证码获取时间间隔，每天只能获取5次验证码，每隔120秒获取一次
		
		//将验证码信息写入数据库
		
		//以json格式返回验证码以及提示信息
		
		// 		$this->layout = false;
// 		return $this->render('index');
		// 		return "index";
		
		// 插入短信验证码信息
// 		$this->layout = false;
		
// 		$list = SysParameter::find()->all();		
		
		$json->status = true;
		$json->message = '验证码已经发送，请注意查收！';
		return Json::encode($json);
// 		return json_encode(ArrayHelper::map($list,"id", "param_val"));
// 		return Json::encode(ArrayHelper::map($list,"id", "param_val"));
// 		return $this->render('index');
// 		return "index";
	}
	
	
	/* public function actionGetSmsCode() {
		
	} */
}
