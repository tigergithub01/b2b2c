<?php

namespace app\modules\vip;

use Yii;

/**
 * vip module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\vip\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        //自定义资源文件
        $this->registerTranslations();
        
        //定义Module的layout
        $this->layout="main";
         
        //重定义默认路由
        $this->defaultRoute="/default/index";
         
        //错误处理页面
        \Yii::trace(Yii::$app->errorHandler->errorAction);
        Yii::$app->errorHandler->errorAction = '/vip/common/error/error';
         
        //app的名字
//         Yii::$app->name="My Application";
        Yii::$app->name=$this::t("app", "app_vip_name");
        
        //设置显示样式
        Yii::$app->assetManager->bundles = [
        		'dmstr\web\AdminLteAsset' => [
        				//         						'skin' => '_all-skins',
        				'skin' => 'skin-blue-light',
        				//         						'skin' => 'skin-black-light',
        		],
        ];
         
        //homeUrl
        Yii::$app->homeUrl="/vip";
    }
    
    /*
     * Module定义自己的资源文件
     * eg.
     * Module::t('app', 'your custom validation message')
     *
     *   */
    public function registerTranslations()
    {
    	\Yii::$app->i18n->translations['modules/vip/*'] = [
    			'class' => 'yii\i18n\PhpMessageSource',
    			'sourceLanguage' => 'en-US',
    			'basePath' => '@app/modules/vip/messages',
    			'fileMap' => [
    					'modules/vip/app' => 'app.php',
    			],
    	];
    }
    
    public static function t($category, $message, $params = [], $language = null)
    {
    	return Yii::t('modules/vip/' . $category, $message, $params, $language);
    }
}
