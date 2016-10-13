<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ReturnSheetDetail */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Return Sheet Detail',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Return Sheet Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="return-sheet-detail-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
