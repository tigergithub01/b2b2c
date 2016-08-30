<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SheetType */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="sheet-type-form box-body">

    <?php $form = ActiveForm::begin(['id'=>'sheet-type-form','options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal'],]); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'请输入单据名称',])->label('单据名称 mine'); ?>
    
    <?php //echo Html::input("text","name",'1')?>
    <?php //echo Html::activeInput("text", $model, "name",[])?>

    <?= $form->field($model, 'prefix')->textInput(['maxlength' => true]) ?>

    <?= 
    //$form->field($model, 'date_format')->textInput(['maxlength' => true])
    //form-control
    $form->field($model, 'date_format')->widget(\yii\jui\DatePicker::classname(), [ 'dateFormat' => 'yyyy-MM-dd','inline'=>false,'class'=>'form-control', ])
    ?>

    <?= $form->field($model, 'sep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seq_length')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cur_seq')->textInput(['maxlength' => true]) ?>
    
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
