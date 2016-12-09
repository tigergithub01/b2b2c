<?php

namespace app\modules\merchant\service\vip;

use Yii;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;
use app\modules\merchant\models\MerchantConst;
use app\models\b2b2c\SysVerifyCode;
use yii\base\View;
use app\models\b2b2c\VipOrganization;
use app\models\b2b2c\VipExtend;
use app\models\b2b2c\VipProductType;
use app\models\b2b2c\Product;
use app\common\utils\ConfigUtils;

class MerchantService{
	/**
	 * 商户登陆
	 * @param unknown $model
	 */
	public function login($model,$auto_login=false){
// 				//for test
		$model = empty($model)?(new Vip()):$model;
		
		if(!$model->validate()){
			return false;
		}
		
		//判断用户名是否存在
// 		$_user = Vip::find()->where(['vip_id'=>$model->vip_id])->andWhere(['merchant_flag'=>SysParameter::yes])->one();
		$_vip = Vip::find()->where(['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::yes])->one();
// 		$_user = Vip::find()->where('vip_id=:vip_id AND merchant_flag=:merchant_flag',['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::yes])->one();
		if(empty($_vip)){
			$model->addError("vip_id",Yii::t('app', '该手机号码未注册！'));
			return false;
		}
		 
		//判断用户是否有效
		if($_vip->status==SysParameter::no){
			$model->addError("vip_id",Yii::t('app', '该用户已停用'));
			return false;
		}
		 
		//判断密码
		if($auto_login){
			if(!strcmp($model->password, $_vip->password)==0){
				$model->addError("password",Yii::t('app', '密码不正确'));
				return false;
			}
		}else{
			if(!strcmp(md5($model->password), $_vip->password)==0){
				$model->addError("password",Yii::t('app', '密码不正确'));
				return false;
			}
		}
		
		//更新最后一次登录时间
		$_vip->last_login_date = \app\common\utils\DateUtils::formatDatetime();
		$_vip->update(true,['last_login_date']);
		
		return $_vip;
	}
	
	/**
	 * 商户注册
	 * @param unknown $model
	 */
	public function register($model){
		
		//for test
		$model = empty($model)?(new Vip()):$model;
		
		if(!$model->validate()){
			return false;
		}
		
		//copy values
		/* $vip = new Vip();
		$vip->vip_id = $model->vip_id;
		$vip->merchant_flag = SysParameter::yes;
		$vip->password = md5($model->password);//md5 加密
		$vip->email_verify_flag=SysParameter::no;
		$vip->status = SysParameter::yes;
		$vip->register_date=\app\common\utils\DateUtils::formatDatetime();
		$vip->audit_status = SysParameter::audit_need_approve;
		$vip->mobile_verify_flag=SysParameter::yes;
		$vip->vip_type_id = $model->vip_type_id; */
		
		
		$model->merchant_flag= SysParameter::yes;
		$model->email_verify_flag=SysParameter::no;
		$model->status = SysParameter::yes;
		$model->register_date=\app\common\utils\DateUtils::formatDatetime();
		$model->audit_status = SysParameter::audit_need_submit;
		$model->mobile_verify_flag = SysParameter::yes;
		$model->password = md5($model->password);
		$model->last_login_date = \app\common\utils\DateUtils::formatDatetime();//注册成功后自动登录
		
		//判断该用户是否已经注册
		$count = Vip::find()->where(['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::yes])->count();
		if ($count>0){
			$model->addError("vip_id",Yii::t('app', '该手机号码已经注册。'));
			return false;
		}
		
		//判断短信验证码是否正确，根据最后发送的有效的验证码进行查询
		$verifyCode= SysVerifyCode::find()->where(['verify_number'=>$model->vip_id,'verify_type'=>SysParameter::verify_mobile])->andWhere(['>=','expiration_time',\app\common\utils\DateUtils::formatDatetime()])->orderBy(['sent_time'=>SORT_DESC])->one();
		if(($model->sms_code !=ConfigUtils::get_universal_sms_code()) && !($verifyCode && $verifyCode->verify_code==$model->sms_code)){
			$model->addError("sms_code",Yii::t('app', '短信验证码不正确。'));
			return false;
		}		
		
		if(!$model->agreement){
			$model->addError("agreement",Yii::t('app', '请遵守协议。'));
			return false;
		}
		
		//插入用户信息，并且是未审核状态
		$transaction = Vip::getDb()->beginTransaction();
		try {
			if(!($model->insert(false))){
				Yii::error($model->errors);
				$model->addError("vip_id",Yii::t('app', '手机号码注册不成功。'));
				$transaction->rollBack();
				return false;
			}
			
			//insert VipOrganization,插入店铺信息，（因为没有店铺的概念，但是为了保证扩展性，所有默认插入一个店铺）
			$vipOrg =  new VipOrganization();
			$vipOrg->status=SysParameter::yes;
			$vipOrg->vip_id = $model->id;
			$vipOrg->name = $model->vip_id;
			$vipOrg->audit_status = SysParameter::audit_need_approve;
			$vipOrg->create_date = \app\common\utils\DateUtils::formatDatetime();
			$vipOrg->update_date = \app\common\utils\DateUtils::formatDatetime();
			
			if(!($vipOrg->insert())){
				Yii::error($vipOrg->errors);
				$model->addError("vip_id",Yii::t('app', '手机号码注册不成功。'));
				$transaction->rollBack();
				return false;
			}
			
			//insert VipOrganization extend，插入扩展信息(用来存放商户省份证等你信息）
			$vipExtend = new VipExtend();
			$vipExtend->audit_status  = SysParameter::audit_need_approve;
			$vipExtend->vip_id = $model->id;
			$vipExtend->create_date = \app\common\utils\DateUtils::formatDatetime();
			$vipExtend->update_date = \app\common\utils\DateUtils::formatDatetime();
			if(!($vipExtend->insert())){
				Yii::error($vipExtend->errors);
				$model->addError("vip_id",Yii::t('app', '手机号码注册不成功。'));
				$transaction->rollBack();
				return false;
			}	
			
			
			//根据商户类型查询出对应的产品分类信息 VipProductType
			$productType = VipProductType::find()->alias('vpt')->select("pt.*")->joinWith("vipType vt")->joinWith("productType pt")->where(['vpt.vip_type_id'=>$model->vip_type_id])->one();
			if(empty($productType)){
				Yii::error("会员类型对应的产品服务类别不存在！");
				$model->addError("vip_id",Yii::t('app', '手机号码注册不成功。'));
				$transaction->rollBack();
				return false;
			}
			
			//insert Product 插入产品(服务）信息-婚礼兔特殊处理
			$product = new Product();
			$product->name = $model->vip_name;
			$product->type_id = $productType->id;
			$product->market_price = 0;
			$product->sale_price = 0;
			$product->deposit_amount = 0;
			$product->is_on_sale = Product::is_on_sale_yes;
			$product->is_hot = SysParameter::no;
			$product->audit_status = SysParameter::audit_need_approve;
			$product->can_return_flag = SysParameter::no;
			$product->vip_id = $model->id;
			$product->is_free_shipping = SysParameter::no;
			$product->service_flag = SysParameter::yes;
			if(!($product->insert())){
				Yii::error($product->errors);
				$model->addError("vip_id",Yii::t('app', '手机号码注册不成功。'));
				$transaction->rollBack();
				return false;
			}
			
			//写session
			$session = Yii::$app->session;
			$session->set(MerchantConst::LOGIN_MERCHANT_USER,$model->getWebVip());
			//写权限信息 TOOD：
			
			
			//写cookie
			//     			if($model->remember_me){
			//write user name into cookie
			// 				setcookie(AdminConst::COOKIE_ADMIN_USER_ID,$user_db->user_id,time()+3600*24*7);
			// 				setcookie(AdminConst::COOKIE_ADMIN_PASSWORD,$user_db->password,time()+3600*24*7);
			
			$cookies = Yii::$app->response->cookies;
			// 				$cookies->set(AdminConst::COOKIE_ADMIN_USER_ID,$user_db->user_id);
			$cookies->add(new \yii\web\Cookie([
					'name' => MerchantConst::COOKIE_MERCHANT_USER_ID,
					'value' => $model->vip_id,
					'expire'=>time()+3600*24*7
			]));
			$cookies->add(new \yii\web\Cookie([
					'name' => MerchantConst::COOKIE_MERCHANT_PASSWORD,
					'value' => $model->password,
					'expire'=>time()+3600*24*7
			]));
			
			//提交事务
			$transaction->commit();
		} catch (\Exception $e) {
			$transaction->rollBack();
            throw $e;
		}
		return $model;
	}
	
	
	/**
	 * 商户修改密码
	 * @param unknown $model
	 */
	public function forgot_pwd($model){
		
		//for test
		$model = empty($model)?(new Vip()):$model;
		if(!$model->validate()){
			return false;
		}
		
		//判断该用户是否已经注册
		$vip_db = Vip::find()->where(['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::yes])->one();
		if (empty($vip_db)){
			$model->addError("vip_id",Yii::t('app', '该手机号码未注册。'));
			return false;
		}
	
		//判断短信验证码是否正确，根据最后发送的有效的验证码进行查询
		$verifyCode= SysVerifyCode::find()->where(['verify_number'=>$model->vip_id,'verify_type'=>SysParameter::verify_mobile])->andWhere(['>=','expiration_time',\app\common\utils\DateUtils::formatDatetime()])->orderBy(['sent_time'=>SORT_DESC])->one();
		if(!($verifyCode && $verifyCode->verify_code==$model->sms_code)){
			$model->addError("sms_code",Yii::t('app', '短信验证码不正确。'));
			return false;
		}
	
		//修改用户密码
// 		Vip::updateAll(['password'=>md5($model->password)],['vip_id'=>$model->vip_id,'merchant_flag'=>SysParameter::yes]);
		$vip_db->password = md5($model->password);
// 		$vip_db->update(true,['password']);
		
		if(!($vip_db->save(true,['password']))){
			Yii::info($model->errors);
			$model->addError("vip_id",Yii::t('app', '修改密码不成功。'));
			return false;
		}
	
		return $vip_db;
	}
	
	/**
	 * 注销当前登录
	 */
	public function logout(){
		//clear session
    	$session = Yii::$app->session;
    	unset($session[MerchantConst::LOGIN_MERCHANT_USER]);    	
    	
    	//clear cookie
    	$cookies = Yii::$app->request->cookies;
    	if(isset($cookies[MerchantConst::COOKIE_MERCHANT_USER_ID])){
	    	Yii::$app->response->cookies->remove(MerchantConst::COOKIE_MERCHANT_USER_ID);
	    	Yii::$app->response->cookies->remove(MerchantConst::COOKIE_MERCHANT_PASSWORD);
// 	    	unset(Yii::$app->response->cookies[MerchantConst::COOKIE_ADMIN_USER_ID]);
    	}
//     	unset($_COOKIE[MerchantConst::COOKIE_ADMIN_USER_ID]);

    	//清空最后一次访问链接
    	$session->remove(MerchantConst::MERCHANT_LAST_ACCESS_URL);
	}
	
	
	/**
	 * 用户自己修改密码
	 * @param unknown $model
	 */
	public function modify_pwd($model){
		if(YII_DEBUG){
			$model = empty($model)?(new Vip()):$model; //for test
			$_user = isset($_user)?null:(new Vip()); //for test
		}
		 
		if(!$model->validate()){
			return false;
		}
		 
		//判断用户是否存在
		
		$_user = Vip::findOne($model->id);
		if(empty($_user)){
			$model->addError("password",Yii::t('app', '用户不存在。'));
			return false;
		}
		 
		//判断原始密码是否正确
		if(strcmp(md5($model->password), $_user->password)!=0){
			$model->addError("password",Yii::t('app', '密码不正确。'));
			return false;
		}
		 
		$_user->password = md5($model->new_pwd);
		if(!($_user->save(true,['password']))){
			$model->addError("password",Yii::t('app', '密码修改不成功。'));
			return false;
		}
		 
		return $_user;
	}
	
	
	/**
	 * 插入店铺信息，商户注册成功后默认增加一个店铺（属于特殊处理，正常情况下应该是先有店铺信息然后才有商品信息）
	 * @param unknown $vip_id
	 */
	function initVipOrg($vip_id){	

		//insert VipOrganization
		$vipOrg =  new VipOrganization();
		$vipOrg->status=SysParameter::yes;
		$vipOrg->vip_id = $vip_id;
		$vipOrg->audit_status = SysParameter::audit_need_approve;
		$vipOrg->insert();
		
		//insert VipOrganization extend
		$vipExtend = new VipExtend();
		$vipExtend->audit_status  = SysParameter::audit_need_approve;
		$vipExtend->vip_id = $vip_id;
		$vipExtend->insert();
		
	}
	
	
}