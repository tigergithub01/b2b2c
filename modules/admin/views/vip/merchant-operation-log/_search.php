<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\MerchantOperationLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-operation-log-search">
	
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

    <?= $form->field($model, 'vip_id') ?>

    <?= $form->field($model, 'module_id') ?>

    <?= $form->field($model, 'op_date') ?>

    <?= $form->field($model, 'op_ip_addr') ?>

    <?php // echo $form->field($model, 'op_browser_type') ?>

    <?php // echo $form->field($model, 'op_phone_model') ?>

    <?php // echo $form->field($model, 'op_url') ?>

    <?php // echo $form->field($model, 'op_desc') ?>

    <?php // echo $form->field($model, 'op_os_type') ?>

    <?php // echo $form->field($model, 'op_method') ?>

    <?php // echo $form->field($model, 'op_app_ver') ?>

    <?php // echo $form->field($model, 'op_app_type_id') ?>

    <?php // echo $form->field($model, 'op_module') ?>

    <?php // echo $form->field($model, 'op_controller') ?>

    <?php // echo $form->field($model, 'op_action') ?>

    <?php // echo $form->field($model, 'op_referrer') ?>

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Yii::t('app', 'Create Vip Operation Log'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
