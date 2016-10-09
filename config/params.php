<?php
return [ 
		'adminEmail' => 'admin@example.com',

	/* 阿里云短信发送 */
	'ali_sms' => [
				// 正式
// 				'appkey' => '23461238',
// 				'secretKey' => 'cd93297388d840d9ee09cb632dbf6cc4',
				
				// 测试
				'appkey' => '1023461238',
				'secretKey' => 'sandbox388d840d9ee09cb632dbf6cc4',

				'sms_free_sign_name' => '幸福点网络科技', 
				'sms_template_code' => 'SMS_15195053',
				
		], 
];
