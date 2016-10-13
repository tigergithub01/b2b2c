<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\RefundSheetApply */

$this->title = Yii::t('app', 'Create Refund Sheet Apply');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Refund Sheet Applies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-sheet-apply-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
