<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\b2b2c\common\Constant;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\RefundSheetApplySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-sheet-apply-search">
	
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

    <?php // echo $form->field($model, 'sheet_type_id') ?>

    <?php //echo $form->field($model, 'vip_id') ?>
    
    <?php // echo $form->field($model, 'vip_no') ?>
    
    <?= $form->field($model, 'vip_name') ?>

    <?php //echo $form->field($model, 'order_id') ?>
    
    <?= $form->field($model, 'order_code') ?>

    <?php // echo $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'status') ?>
    
    <?= $form->field($model, 'status')->dropDownList(\yii\helpers\ArrayHelper::map($refundApplyStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'apply_date') ?>
    
    <?= $form->field($model, 'start_date')->widget(dosamigos\datepicker\DateRangePicker::className(), [
    		'attributeTo' => 'end_date',
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_PICKER_FORMAT,
    			]
          ]) ?>

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Module::t('app', 'Create Refund Sheet Apply'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
