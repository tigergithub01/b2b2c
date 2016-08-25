<?php

namespace app\assets\admin;

use yii\web\AssetBundle;

/**
 * @author Tiger-guo
 */
class AdminIcheckPluginAsset extends AssetBundle
{
	public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';
	public $css = [
			'iCheck/square/blue.css'
	];
	public $js = [
			'iCheck/icheck.min.js'
	];
}