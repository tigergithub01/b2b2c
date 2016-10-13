<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipExtend */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Vip Extend',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Extends'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-extend-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
