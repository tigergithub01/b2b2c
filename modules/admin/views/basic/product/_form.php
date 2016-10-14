<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'type_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'type_id')->dropDownList(\yii\helpers\ArrayHelper::map($ptypeList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'brand_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'brand_id')->dropDownList(\yii\helpers\ArrayHelper::map($pbrandList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'market_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sale_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deposit_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php //echo $form->field($model, 'is_on_sale')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'is_on_sale')->dropDownList(\yii\helpers\ArrayHelper::map($pStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'is_hot')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'is_hot')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'audit_status')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'audit_status')->dropDownList(\yii\helpers\ArrayHelper::map($auditStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'audit_user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audit_date')->textInput() ?>

    <?= $form->field($model, 'stock_quantity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'safety_quantity')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'can_return_flag')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'can_return_flag')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'return_days')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'return_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cost_price')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'vip_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'vip_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipList, "id", "vip_id"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'is_free_shipping')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'is_free_shipping')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'give_integral')->textInput() ?>

    <?= $form->field($model, 'rank_integral')->textInput() ?>

    <?= $form->field($model, 'integral')->textInput() ?>

    <?= $form->field($model, 'relative_module')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bonus')->textInput() ?>

    <?= $form->field($model, 'product_weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_weight_unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_group_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_original')->textInput(['maxlength' => true]) ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
