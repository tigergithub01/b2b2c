<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ProductType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-type-form">

	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title" style="visibility: visible;"><?= Html::encode($this->title) ?></h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool"
					data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>

	    <?php $form = ActiveForm::begin([
	    	'options' => [ 
						'enctype' => 'multipart/form-data',
						'class' => 'form-horizontal',
				],
				'fieldConfig' => [ 
						'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
						'labelOptions' => [ 
								'class' => 'col-lg-2 control-label' 
						] 
				],
	    ]); ?>
    
    	<?php //echo $form->errorSummary($model);?>

	    <div class="box-body">
	    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'parent_id')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'parent_id')->dropDownList(\yii\helpers\ArrayHelper::map($pTypeList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')])?>
	
	<?=  $form->field($model, 'parent_id')->widget(\kartik\select2\Select2::className(),[
			'data' => \yii\helpers\ArrayHelper::map($pTypeList, "id", "name"),
			'options' => [
					'prompt' => Yii::t('app', 'select_prompt'),
			],
			'pluginOptions' => [
					'allowClear' => true
			],
		] ) ?>
		
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seq_id')->textInput() ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
