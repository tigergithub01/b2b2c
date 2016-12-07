<?php

namespace app\modules\vip\models;

class VipConst{
	const LOGIN_VIP_USER = 'login_vip_user';
	const COOKIE_VIP_USER_ID= 'cookie_vip_user_id';
	const COOKIE_VIP_PASSWORD= 'cookie_vip_password';
	
	
	/* 金额与价格格式 */
	const DECIMAL_FORMAT = '0.00';
	
	/* 验证码sesssion key */
	const CAPTCHA_ACTION_KEY = '__captcha/site/captcha';
	
	/* 最后一次访问URL */
	const VIP_LAST_ACCESS_URL = 'vip_last_access_url';
	
	
}