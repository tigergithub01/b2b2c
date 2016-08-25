<?php

namespace app\assets\admin;

use yii\web\AssetBundle;
use app\assets\admin\AdminAsset;
/**
 * @author Tiger-guo
 */
class AdminLoginAsset extends AdminAsset
{
	
	public $depends = [
			'app\assets\admin\AdminAsset',
			'app\assets\admin\AdminIcheckPluginAsset',
	];
}