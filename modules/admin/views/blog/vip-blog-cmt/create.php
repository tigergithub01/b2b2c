<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipBlogCmt */

$this->title = Module::t('app', 'Create Vip Blog Cmt');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Blog Cmts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-blog-cmt-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'vipList' => $vipList,
    	'vipBlogList' => $vipBlogList,
    	'yesNoList' => $yesNoList,
    ]) ?>

</div>
