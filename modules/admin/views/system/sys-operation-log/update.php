<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysOperationLog */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Sys Operation Log'),
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Operation Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-operation-log-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
