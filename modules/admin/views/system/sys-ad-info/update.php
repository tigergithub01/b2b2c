<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysAdInfo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sys Ad Info',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Ad Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-ad-info-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
