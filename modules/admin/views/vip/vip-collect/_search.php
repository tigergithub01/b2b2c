<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\VipCollectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-collect-search">
	
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
	
	    <?php //echo  $form->field($model, 'id') ?>

    <?php //echo $form->field($model, 'vip_id') ?>

    <?php //echo $form->field($model, 'product_id') ?>

    <?php //echo $form->field($model, 'package_id') ?>

    <?php //echo $form->field($model, 'case_id') ?>
    
    <?php // echo $form->field($model, 'vip_no') ?>
    
    <?= $form->field($model, 'vip_name') ?>

    <?= $form->field($model, 'product_name') ?>

    <?= $form->field($model, 'package_name') ?>

    <?= $form->field($model, 'case_name') ?>
    
    <?php // echo $form->field($model, 'blog_id') ?>
    
    <?php // echo $form->field($model, 'ref_vip_id') ?>

    <?php // echo $form->field($model, 'collect_type') ?>
    
    <?= $form->field($model, 'collect_type')->dropDownList(\yii\helpers\ArrayHelper::map($collectTypeList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'collect_date') ?>

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Module::t('app', 'Create Vip Collect'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
