<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipConcern */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Vip Concern',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Concerns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-concern-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
