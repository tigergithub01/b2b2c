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
			'js/plugin/fancyBox/source/jquery.fancybox.css?v=2.1.5'
	];
	public $js = [
		'js/plugin/fancyBox/source/jquery.fancybox.js?v=2.1.5',
		"js/admin/demo.js",
		"js/common/jquery.blockUI.js",
		"js/common/common.js",
// 		"js/plugin/jquery.form.js",
	];
	public $depends = [
			'dmstr\web\AdminLteAsset',
			'app\assets\admin\AdminIoniconsAsset',
			'app\assets\admin\AdminBasePluginAsset',
			
	];
}