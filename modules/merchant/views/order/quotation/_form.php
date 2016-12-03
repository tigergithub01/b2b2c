<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\b2b2c\common\Constant;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Quotation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quotation-form">

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
	    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?php // eho $form->field($model, 'vip_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'vip_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipList, "id", "vip_name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'order_amt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deposit_amount')->textInput(['maxlength' => true]) ?>

    <?php //  echo $form->field($model, 'create_date')->textInput() ?>
    
    <?= $form->field($model, 'create_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    <?php // echo $form->field($model, 'update_date')->textInput() ?>
    
    <?= $form->field($model, 'update_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    <?= $form->field($model, 'memo')->textarea(['rows' => 6]) ?>

    <?php // echo $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'status')->dropDownList(\yii\helpers\ArrayHelper::map($statusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'consignee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'service_date')->textInput() ?>
    
     <?= $form->field($model, 'service_date')->widget(\dosamigos\datepicker\DatePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_PICKER_FORMAT,
    			]
          ]) ?>

    <?= $form->field($model, 'budget_amount')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'related_service')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'related_services')->checkboxList(\yii\helpers\ArrayHelper::map($relatedServiceList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'service_style')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'service_style')->dropDownList(\yii\helpers\ArrayHelper::map($serviceStyleList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'merchant_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'merchant_id')->dropDownList(\yii\helpers\ArrayHelper::map($merchantList, "id", "vip_name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	        
	        <?php if (!($model->isNewRecord)) {echo Html::a('添加订单明细',['create-quotation-detail', 'quotation_id'=>$model->id],['class' => 'btn btn-success']);}?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
