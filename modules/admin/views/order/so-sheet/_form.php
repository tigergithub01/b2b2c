<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
	    <?= $form->field($model, 'sheet_type_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vip_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_amt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_quantity')->textInput() ?>

    <?= $form->field($model, 'goods_amt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deliver_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_date')->textInput() ?>

    <?= $form->field($model, 'delivery_date')->textInput() ?>

    <?= $form->field($model, 'delivery_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_type_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_date')->textInput() ?>

    <?= $form->field($model, 'delivery_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pick_point_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paid_amt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'integral')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'integral_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coupon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'return_amt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'return_date')->textInput() ?>

    <?= $form->field($model, 'memo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'consignee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'province_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'district_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_date')->textInput() ?>

    <?= $form->field($model, 'budget_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'related_service')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_style')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'related_case_id')->textInput(['maxlength' => true]) ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
