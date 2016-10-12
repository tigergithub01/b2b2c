<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysNotify */

$this->title = Yii::t('app', 'Create Sys Notify');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Notifies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-notify-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
