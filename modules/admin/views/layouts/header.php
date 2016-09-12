<?php
use yii\helpers\Html;
use app\modules\admin\Module;
/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">'.Module::t('app', 'app_admin_short_name').'</span><span class="logo-lg">' . Module::t('app', 'app_admin_name') . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li>
                      <?= Html::a(  '注销',
                                    ['/admin/default/logout'],
                                    ['data-method' => 'post','data' => [
	                'confirm' => Module::t('app', '是否退出?'),
	                'method' => 'post',
                    'class' => 'glyphicon glyphicon-user',               		
	            ],]
                                ) ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
