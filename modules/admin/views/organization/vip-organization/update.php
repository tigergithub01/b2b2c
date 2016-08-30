<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipOrganization */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Vip Organization',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Organizations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-organization-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
