<?php

namespace app\assets\admin;

use yii\web\AssetBundle;

/**
 * @author Tiger-guo
 */
class AdminIoniconsAsset extends AssetBundle
{
	public $sourcePath = '@bower/ionicons';
    public $css = [
        'css/ionicons.min.css',
    ];
}