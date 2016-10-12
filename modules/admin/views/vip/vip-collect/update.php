<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCollect */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Vip Collect',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Collects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-collect-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
