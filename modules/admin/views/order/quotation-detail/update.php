<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\QuotationDetail */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Quotation Detail',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Quotation Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="quotation-detail-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
