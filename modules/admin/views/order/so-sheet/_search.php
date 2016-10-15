<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\SoSheetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="so-sheet-search">
	
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
	
	    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sheet_type_id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'vip_id') ?>

    <?= $form->field($model, 'order_amt') ?>

    <?php // echo $form->field($model, 'order_quantity') ?>

    <?php // echo $form->field($model, 'goods_amt') ?>

    <?php // echo $form->field($model, 'deliver_fee') ?>

    <?php // echo $form->field($model, 'order_date') ?>

    <?php // echo $form->field($model, 'delivery_date') ?>

    <?php // echo $form->field($model, 'delivery_type') ?>

    <?php // echo $form->field($model, 'pay_type_id') ?>

    <?php // echo $form->field($model, 'pay_date') ?>

    <?php // echo $form->field($model, 'delivery_no') ?>

    <?php // echo $form->field($model, 'pick_point_id') ?>

    <?php // echo $form->field($model, 'paid_amt') ?>

    <?php // echo $form->field($model, 'integral') ?>

    <?php // echo $form->field($model, 'integral_money') ?>

    <?php // echo $form->field($model, 'coupon') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'return_amt') ?>

    <?php // echo $form->field($model, 'return_date') ?>

    <?php // echo $form->field($model, 'memo') ?>

    <?php // echo $form->field($model, 'message') ?>

    <?php // echo $form->field($model, 'order_status') ?>

    <?php // echo $form->field($model, 'delivery_status') ?>

    <?php // echo $form->field($model, 'pay_status') ?>

    <?php // echo $form->field($model, 'consignee') ?>

    <?php // echo $form->field($model, 'country_id') ?>

    <?php // echo $form->field($model, 'province_id') ?>

    <?php // echo $form->field($model, 'city_id') ?>

    <?php // echo $form->field($model, 'district_id') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'detail_address') ?>

    <?php // echo $form->field($model, 'invoice_type') ?>

    <?php // echo $form->field($model, 'invoice_header') ?>

    <?php // echo $form->field($model, 'service_date') ?>

    <?php // echo $form->field($model, 'budget_amount') ?>

    <?php // echo $form->field($model, 'related_service') ?>

    <?php // echo $form->field($model, 'service_style') ?>

    <?php // echo $form->field($model, 'related_case_id') ?>

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Module::t('app', 'Create So Sheet'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
