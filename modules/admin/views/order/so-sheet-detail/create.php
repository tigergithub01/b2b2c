<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SoSheetDetail */

$this->title = Yii::t('app', 'Create So Sheet Detail');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'So Sheet Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-sheet-detail-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
