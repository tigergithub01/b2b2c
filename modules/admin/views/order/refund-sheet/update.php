<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\RefundSheet */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Refund Sheet',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Refund Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="refund-sheet-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
