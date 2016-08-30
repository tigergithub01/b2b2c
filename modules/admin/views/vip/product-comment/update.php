<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ProductComment */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Product Comment',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-comment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
