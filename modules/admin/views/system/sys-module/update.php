<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysModule */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sys Module',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Modules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-module-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
