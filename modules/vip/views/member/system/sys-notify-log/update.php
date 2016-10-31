<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysNotifyLog */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sys Notify Log',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Notify Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-notify-log-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
