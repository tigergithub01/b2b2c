<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipBlogCmt */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Vip Blog Cmt',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Blog Cmts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-blog-cmt-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
