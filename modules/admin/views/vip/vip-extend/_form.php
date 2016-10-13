<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipExtend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-extend-form">

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

    <?= $form->field($model, 'real_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_card_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_card_img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_card_thumb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_card_img_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_back_img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_back_thumb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_back_img_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bl_img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bl_thumb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bl_img_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_addr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audit_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audit_user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audit_date')->textInput() ?>

    <?= $form->field($model, 'audit_memo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <?= $form->field($model, 'update_date')->textInput() ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
