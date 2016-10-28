<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysNotifyLog */

$this->title = Yii::t('app', 'Create Sys Notify Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Notify Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-notify-log-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
