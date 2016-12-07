<?php

namespace app\modules\admin\models;

class AdminConst{
	/* cookie  */
	const LOGIN_ADMIN_USER = 'login_admin_user';
	const COOKIE_ADMIN_USER_ID= 'cookie_admin_user_id';
	const COOKIE_ADMIN_PASSWORD= 'cookie_admin_password';
	
	/* 日期格式  */
	const DATE_FORMAT='Y-m-d';
	
	/* 金额与价格格式 */
	const DECIMAL_FORMAT = '0.00';
	
	/* 验证码sesssion key */
	const CAPTCHA_ACTION_KEY = '__captcha/site/captch';
	
	/* 最后一次访问URL */
	const ADMIN_LAST_ACCESS_URL = 'admin_last_access_url';
	
	/* 系统配置  */
	static $config = [];
}