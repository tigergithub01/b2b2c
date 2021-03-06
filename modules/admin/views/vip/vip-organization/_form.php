<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipOrganization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-organization-form">

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

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logo_img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logo_thumb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logo_img_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cover_img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cover_thumb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cover_img_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vip_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'province_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audit_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audit_user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audit_date')->textInput() ?>

    <?= $form->field($model, 'audit_memo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <?= $form->field($model, 'update_date')->textInput() ?>

    <?= $form->field($model, 'district_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
