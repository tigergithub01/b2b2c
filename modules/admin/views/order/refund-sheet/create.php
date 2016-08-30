<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\RefundSheet */

$this->title = Yii::t('app', 'Create Refund Sheet');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Refund Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-sheet-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
