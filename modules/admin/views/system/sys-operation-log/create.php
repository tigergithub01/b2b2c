<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysOperationLog */

$this->title = Yii::t('app', 'Create Sys Operation Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Operation Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-operation-log-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
