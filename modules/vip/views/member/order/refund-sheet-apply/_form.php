<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Console;
use app\models\b2b2c\common\Constant;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\RefundSheetApply */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-sheet-apply-form">

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
	    <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
	    
	    <?php // echo $form->field($model, 'sheet_type_id')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'vip_id')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'vip_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipList, "id", "vip_name"), ['prompt' => Yii::t('app', 'select_prompt'), 'disabled' => true, ]) ?>

    <?php // echo  $form->field($model, 'order_id')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'order_id')->dropDownList(\yii\helpers\ArrayHelper::map($soSheetList, "id", "code"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <?php // echo  $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'status')->dropDownList(\yii\helpers\ArrayHelper::map($refundApplyStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'apply_date')->textInput() ?>
    
    
    <?php /* $form->field($model, 'apply_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ])*/ ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
