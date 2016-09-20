<?php

namespace app\modules\merchant\models;

class MerchantConst{
	const LOGIN_MERCHANT_USER = 'login_merchant_user';
	const COOKIE_MERCHANT_USER_ID= 'cookie_merchant_user_id';
	const COOKIE_MERCHANT_PASSWORD= 'cookie_merchant_password';
	
	/* 日期格式 */
	const DATE_FORMAT='Y-m-d H:i:s';
	
	/* 金额与价格格式 */
	const DECIMAL_FORMAT = '0.00';
	
	/* 验证码sesssion key */
	const CAPTCHA_ACTION_KEY = '__captcha/site/captcha';
	
	/* 最后一次访问URL */
	const MERCHANT_LAST_ACCESS_URL = 'merchant_last_access_url';
	
}