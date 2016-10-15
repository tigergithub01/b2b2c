<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Activity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-form">

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

    <?php //echo $form->field($model, 'activity_type')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'activity_type')->dropDownList(\yii\helpers\ArrayHelper::map($activityTypeList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'activity_scope')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'activity_scope')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'start_time')->textInput() ?>
    
    <?= $form->field($model, 'start_time')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => \app\models\b2b2c\common\Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    <?php //echo $form->field($model, 'end_date')->textInput() ?>
    
    <?= $form->field($model, 'end_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => \app\models\b2b2c\common\Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'package_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deposit_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'buy_limit_num')->textInput() ?>

    <?php //echo $form->field($model, 'vip_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'vip_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipList, "id", "vip_id"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_original')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'audit_status')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'audit_status')->dropDownList(\yii\helpers\ArrayHelper::map($auditStatList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'audit_user_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'audit_user_id')->dropDownList(\yii\helpers\ArrayHelper::map($sysUserList, "id", "user_id"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'audit_date')->textInput() ?>
    
    <?= $form->field($model, 'audit_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => \app\models\b2b2c\common\Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
