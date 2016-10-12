<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ProductType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Product Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
