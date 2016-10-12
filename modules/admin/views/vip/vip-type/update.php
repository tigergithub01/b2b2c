<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Vip Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
