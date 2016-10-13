<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ReturnSheetDetail */

$this->title = Yii::t('app', 'Create Return Sheet Detail');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Return Sheet Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="return-sheet-detail-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
