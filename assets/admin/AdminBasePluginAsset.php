<?php

namespace app\assets\admin;

use yii\web\AssetBundle;

/**
 * @author Tiger-guo
 */
class AdminBasePluginAsset extends AssetBundle
{
	public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';
	public $js = [
			'slimScroll/jquery.slimscroll.min.js',
			'fastclick/fastclick.js',
	];
}