<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysNotify */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sys Notify',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Notifies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-notify-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
