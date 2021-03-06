<?php
use yii\helpers\Html;
use app\modules\vip\Module;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">'.Module::t('app', 'app_vip_short_name').'</span><span class="logo-lg">' . Module::t('app', 'app_vip_name') . '</span>', ['member/default/index'], ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li>
                      <?= Html::a(  '注销',
                                    ['/vip/member/default/logout'],
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
