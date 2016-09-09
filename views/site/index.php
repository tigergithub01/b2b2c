<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
		
		<h1>Welcome!</h1>

        <p class="lead">You have successfully created your application.</p>
		
		<p><a class="btn btn-lg btn-primary" href="<?= Url::to(['/vip'])?>">安卓版下载</a></p>

        <p><a class="btn btn-lg btn-primary" href="<?= Url::to(['/merchant'])?>">商家中心</a></p>
        
        <p><a class="btn btn-lg btn-primary" href="<?= Url::toRoute(['/admin'])?>">后台管理</a></p>
        
    </div>

    <div class="body-content">
		
        

    </div>
</div>
