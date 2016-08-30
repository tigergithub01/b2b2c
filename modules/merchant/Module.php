<?php

namespace app\modules\merchant;

use Yii;

/**
 * merchant module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\merchant\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        
        //定义Module的layout
        $this->layout="main";
         
        //重定义默认路由
        $this->defaultRoute="/default/index";
         
        //错误处理页面
        \Yii::trace(Yii::$app->errorHandler->errorAction);
        Yii::$app->errorHandler->errorAction = '/merchant/common/error/error';
         
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
        Yii::$app->homeUrl="/merchant";
        
    }
}
