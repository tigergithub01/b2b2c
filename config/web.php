<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'tiger',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
//                     'levels' => ['error', 'warning'],
                	'levels' => ['error', 'warning','info'/* ,'trace','profile' */],
                	'prefix' => function ($message) {
                		$user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                		$userID = $user ? $user->getId(false) : '-';
                		return "[$userID]";
                	},
                	'maxFileSize' => 1024 * 10,
//                 	'maxLogFiles' => 100,
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        	/* 'suffix' => '.shtml', */
            'rules' => [
            	/* 'login'=>'site/login', */
            	/* '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
            	'<controller:\w+>/<action:\w+>'=>'<controller>/<action>', */
            ],
        ],
        'i18n' => [
        		'translations' => [
        				'app*' => [
        						'class' => 'yii\i18n\PhpMessageSource',
        						//'basePath' => '@app/messages',
        						'sourceLanguage' => 'en-US',
        						'fileMap' => [
        								'app' => 'app.php',
        								'app/error' => 'error.php',
        								'app/admin' => 'admin/app.php',
        								'app/merchant' => 'merchant/app.php',
        								'app/vip' => 'vip/app.php',
        						],
        				],
        		],
        ],
        'assetManager' => [
//         		'linkAssets' => true,//清除缓存
        		'bundles' => [
        				'yii\web\JqueryAsset' => [
        						//'sourcePath' => null,   // 一定不要发布该资源
        						'js' => [
        								//'ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
        								//"js/jquery/jquery-1.8.2.min.js",
        								"jquery.min.js",
        						]
        				],
        				'dmstr\web\AdminLteAsset' => [
//         						'skin' => '_all-skins',
        						'skin' => 'skin-blue-light',
//         						'skin' => 'skin-black-light',
        				],
        		],
		],
		'formatter' => [
				'class' => 'yii\i18n\Formatter',
				'dateFormat' => 'php:Y-m-d',
				'datetimeFormat' => 'php:Y-m-d H:i:s',
				'timeFormat' => 'php:H:i:s',
				//'decimalSeparator' => ',',
		]
       
    ],
	'modules' => [
			'admin' => [
					'class' => 'app\modules\admin\Module',
			],
			'vip' => [
					'class' => 'app\modules\vip\Module',
			],
			'merchant' => [
					'class' => 'app\modules\merchant\Module',
			],
	],
    'params' => $params,
	'language' => 'zh-CN',
	'timeZone' => 'PRC',	
	'on beforeRequest' => function ($event) {
// 		var_dump($_REQUEST);
		//var_dump($_SERVER["REQUEST_URI"]);
// 		XDEBUG_SESSION_START=ECLIPSE_DBGP&KEY=14732173473185

// 		Yii::trace('http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]);
// 		Yii::trace('beforeRequest.');
		// 		var_dump($event);
	},
	'on afterRequest' => function ($event) {
// 		$_REQUEST['XDEBUG_SESSION_START']='ECLIPSE_DBGP';
// 		$_REQUEST['KEY']='14732173473185';
// 		var_dump($_REQUEST);
	},
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    	'generators' => [
    				'crud' => [ //生成器名称
    						'class' => 'yii\gii\generators\crud\Generator',
    						'templates' => [ //设置我们自己的模板
    								//模板名 => 模板路径
    								'myCrud-desktop' => '@app/common/generators/crud/default',
    								'myCrud-mobile' => '@app/common/generators/crud/default',
    						]
    				]
    	],
    ];
}

return $config;
