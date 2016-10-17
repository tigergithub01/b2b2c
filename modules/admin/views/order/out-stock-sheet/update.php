<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\OutStockSheet */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Out Stock Sheet',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Out Stock Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="out-stock-sheet-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
