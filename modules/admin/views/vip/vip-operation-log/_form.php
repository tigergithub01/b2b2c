<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipOperationLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-operation-log-form">

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
	    <?= $form->field($model, 'vip_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'module_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_date')->textInput() ?>

    <?= $form->field($model, 'op_ip_addr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_browser_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_phone_model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'op_os_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_app_ver')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_app_type_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_module')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_controller')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_action')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'op_referrer')->textInput(['maxlength' => true]) ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
