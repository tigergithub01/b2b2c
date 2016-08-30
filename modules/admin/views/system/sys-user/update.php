<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysUser */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sys User',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
