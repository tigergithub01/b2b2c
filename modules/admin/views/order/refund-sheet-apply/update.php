<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\RefundSheetApply */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Refund Sheet Apply',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Refund Sheet Applies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="refund-sheet-apply-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
