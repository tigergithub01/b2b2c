<?php

namespace app\assets\admin;

use yii\web\AssetBundle;

/**
 * @author Tiger-guo
 */
class AdminAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
			'css/admin/admin.css',
	];
	public $js = [
		"js/admin/demo.js",
			
	];
	public $depends = [
			'dmstr\web\AdminLteAsset',
			'app\assets\admin\AdminIoniconsAsset',
			'app\assets\admin\AdminBasePluginAsset',
	];
}