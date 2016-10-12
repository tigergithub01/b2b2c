<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipBlogType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Vip Blog Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Blog Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-blog-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
