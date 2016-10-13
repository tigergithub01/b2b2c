<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCaseType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Vip Case Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Case Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-case-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>