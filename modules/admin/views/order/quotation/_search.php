<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\QuotationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quotation-search">
	
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><?= Yii::t('app', 'Search_criteria') ?></h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>
	
	
	    <?php $form = ActiveForm::begin([
	        'action' => ['index'],
	        'method' => 'get',
	        'options' => ['class' => 'form-horizontal'],
	        'fieldConfig' => [ 
					'template' => "{label}\n<div class=\"col-sm-6\">{input}</div>\n<div class=\"col-sm-3\">{error}</div>",
					'labelOptions' => [ 
							'class' => 'col-sm-3 control-label' 
					], 
					'options'=>['class' => 'form-group col-sm-6'], 
			],
	    ]); ?>
	    
	    <div class="box-body">
	
	    <?php // echo $form->field($model, 'id') ?>

    <?= $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'vip_id')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'vip_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipList, "id", "vip_name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
	
	<?php  echo $form->field($model, 'vip_name')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'order_amt') ?>

    <?= $form->field($model, 'deposit_amount') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'update_date') ?>

    <?php // echo $form->field($model, 'memo') ?>

    <?php // echo $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'status')->dropDownList(\yii\helpers\ArrayHelper::map($statusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'consignee') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'service_date') ?>

    <?php // echo $form->field($model, 'budget_amount') ?>

    <?php // echo $form->field($model, 'related_service') ?>

    <?php // echo $form->field($model, 'service_style') ?>

    <?php // echo $form->field($model, 'merchant_id')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'merchant_id')->dropDownList(\yii\helpers\ArrayHelper::map($merchantList, "id", "vip_name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
	
	<?php echo $form->field($model, 'merchant_name') ?>
		
	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Module::t('app', 'Create Quotation'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
