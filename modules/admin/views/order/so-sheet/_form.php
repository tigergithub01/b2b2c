<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\b2b2c\common\Constant;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SoSheet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="so-sheet-form">

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
	    <?php //echo $form->field($model, 'sheet_type_id')->textInput(['maxlength' => true]) ?>
	    
	    <?= $form->field($model, 'sheet_type_id')->dropDownList(\yii\helpers\ArrayHelper::map($sheetTypeList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'vip_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'vip_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipList, "id", "vip_id"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'order_amt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_quantity')->textInput() ?>

    <?= $form->field($model, 'goods_amt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deliver_fee')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'order_date')->textInput() ?>
    
    <?= $form->field($model, 'order_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    <?= $form->field($model, 'delivery_date')->textInput() ?>

    <?php // echo $form->field($model, 'delivery_type')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'delivery_type')->dropDownList(\yii\helpers\ArrayHelper::map($deliveryTypeList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'pay_type_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'pay_type_id')->dropDownList(\yii\helpers\ArrayHelper::map($payTypeList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'pay_date')->textInput() ?>
    
    <?= $form->field($model, 'pay_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    <?= $form->field($model, 'delivery_no')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'pick_point_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'pick_point_id')->dropDownList(\yii\helpers\ArrayHelper::map($pickUpPointList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'paid_amt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'integral')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'integral_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coupon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'return_amt')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'return_date')->textInput() ?>
    
    <?= $form->field($model, 'return_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    <?= $form->field($model, 'memo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    <?php // echo $form->field($model, 'order_status')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'order_status')->dropDownList(\yii\helpers\ArrayHelper::map($orderStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'delivery_status')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'delivery_status')->dropDownList(\yii\helpers\ArrayHelper::map($deliveryStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'pay_status')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'pay_status')->dropDownList(\yii\helpers\ArrayHelper::map($payStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'consignee')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'country_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'country_id')->dropDownList(\yii\helpers\ArrayHelper::map($countryList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'province_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'province_id')->dropDownList(\yii\helpers\ArrayHelper::map($proviceList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'city_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'city_id')->dropDownList(\yii\helpers\ArrayHelper::map($cityList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'district_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'district_id')->dropDownList(\yii\helpers\ArrayHelper::map($districtList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail_address')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'invoice_type')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'invoice_type')->dropDownList(\yii\helpers\ArrayHelper::map($invoiceTypeList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'invoice_header')->textInput(['maxlength' => true]) ?>

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

    <?php //echo $form->field($model, 'related_case_id')->textInput(['maxlength' => true]) ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
