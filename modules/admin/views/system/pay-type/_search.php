<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\PayTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pay-type-search">
	
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

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'rate') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'configure') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'is_cod') ?>

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Yii::t('app', 'Create_Pay_Type'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
