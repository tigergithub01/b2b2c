<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SheetTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sheet-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'prefix') ?>

    <?= $form->field($model, 'date_format') ?>

    <?php // echo $form->field($model, 'sep') ?>

    <?php // echo $form->field($model, 'seq_length') ?>

    <?php // echo $form->field($model, 'cur_seq') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
