<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\OutStockSheetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="out-stock-sheet-search">
	
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

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'vip_id') ?>

    <?php // echo $form->field($model, 'sheet_date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'delivery_type') ?>

    <?php // echo $form->field($model, 'delivery_no') ?>

    <?php // echo $form->field($model, 'merchant_id') ?>

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Yii::t('app', 'Create Out Stock Sheet'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
