<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysAppInfo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sys App Info',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys App Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-app-info-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
