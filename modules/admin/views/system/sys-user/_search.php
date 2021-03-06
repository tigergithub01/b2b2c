<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\Module;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\SysUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-user-search">
	
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

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'user_name') ?>

    <?php //echo $form->field($model, 'password') ?>

    <?php // $form->field($model, 'is_admin')->dropDownList(ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')])?>

    <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')])?>

    <?php // echo $form->field($model, 'last_login_date') ?>

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Module::t('app', 'Create Sys User'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
