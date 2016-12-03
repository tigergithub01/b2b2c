<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\QuotationDetail */

$this->title = Yii::t('app', 'Create Quotation Detail');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Quotation Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-detail-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
