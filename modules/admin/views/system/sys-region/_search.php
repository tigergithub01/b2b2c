<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\SysRegionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-region-search">
	
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
	
	    <?php //echo $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?php //echo $form->field($model, 'parent_id') ?>
    
    <?php echo $form->field($model, 'parent_name') ?>

    <?php //echo $form->field($model, 'region_type') ?>
    
    <?= $form->field($model, 'region_type')->dropDownList(ArrayHelper::map($regionTypeList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
    

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Module::t('app', 'Create Sys Region'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
