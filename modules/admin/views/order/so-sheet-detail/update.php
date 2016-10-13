<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SoSheetDetail */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'So Sheet Detail',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'So Sheet Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="so-sheet-detail-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
