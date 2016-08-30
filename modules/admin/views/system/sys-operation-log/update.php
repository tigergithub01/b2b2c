<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysOperationLog */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sys Operation Log',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Operation Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-operation-log-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>