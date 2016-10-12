<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipBlogCmt */

$this->title = Yii::t('app', 'Create Vip Blog Cmt');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Blog Cmts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-blog-cmt-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
