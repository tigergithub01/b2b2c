<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\OutStockSheet */

$this->title = Yii::t('app', 'Create Out Stock Sheet');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Out Stock Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="out-stock-sheet-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
