<?php
return [ 
		'adminEmail' => 'admin@example.com',

	/* 阿里云短信发送 */
	'ali_sms' => [
				// 正式
				// 'appkey' => '23461238',
				// 'secretKey' => 'cd93297388d840d9ee09cb632dbf6cc4',
				
				// 测试
				'appkey' => (YII_DEBUG ? '1023461238' : '23461238'),
				'secretKey' => (YII_DEBUG ? 'sandbox388d840d9ee09cb632dbf6cc4' : 'cd93297388d840d9ee09cb632dbf6cc4'),
				
				'sms_free_sign_name' => '幸福点网络科技',
				'sms_template_code' => 'SMS_15195053' 
		]
		, 
		
	/* api 密钥 */
	'api_secret' => [ 
				'appkey' => 'weryjnj7' 
		],
		
	/*  universal sms code */
		'universal_sms_code' => 'wl1234' ,
	'wx_pay'=>[
			'app_id'=>'wx20c0c879e9aa24b7',
			'mch_id'=>'1431555002',
			'app_key'=>'c80487fe8062b2b756a886b08bced7cd',
	]	
];
