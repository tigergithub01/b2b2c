<?php


namespace app\modules\admin;

use Yii;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->registerTranslations();
        
        if (Yii::$app instanceof \yii\console\Application) {
        	//控制台应用
        	$this->controllerNamespace = 'app\modules\admin\commands';
        }else{
        	// \yii\web\Application
        	//web应用
        	//定义Module的layout
        	$this->layout="main";
        	
        	//重定义默认路由
        	$this->defaultRoute="/default/index";
        	
        	//错误处理页面
        	\Yii::trace(Yii::$app->errorHandler->errorAction);
        	Yii::$app->errorHandler->errorAction = '/admin/common/error/error';
        	
        	//app的名字
        	//         Yii::$app->name="婚礼兔";
        	Yii::$app->name="My Application";
        	
        	//设置显示样式
        	Yii::$app->assetManager->bundles = [
        			'dmstr\web\AdminLteAsset' => [
        			//         						'skin' => '_all-skins',
        					'skin' => 'skin-blue-light',
        					//         						'skin' => 'skin-black-light',
        			],
        	];
        	
        	//homeUrl
        	Yii::$app->homeUrl="/admin";
        }
    }
    
    /* 
     * Module定义自己的资源文件
     * eg.
     * Module::t('app', 'your custom validation message')
     *   
     *   */
    public function registerTranslations()
    {
    	\Yii::$app->i18n->translations['modules/admin/*'] = [
    			'class' => 'yii\i18n\PhpMessageSource',
    			'sourceLanguage' => 'en-US',
    			'basePath' => '@app/modules/admin/messages',
    			'fileMap' => [
    					'modules/admin/app' => 'app.php',
    			],
    	];
    }
    
    public static function t($category, $message, $params = [], $language = null)
    {
    	return Yii::t('modules/admin/' . $category, $message, $params, $language);
    }
    
}
