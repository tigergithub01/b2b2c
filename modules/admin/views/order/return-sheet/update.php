<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ReturnSheet */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Return Sheet',
]) . $model->code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Return Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->code, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="return-sheet-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
