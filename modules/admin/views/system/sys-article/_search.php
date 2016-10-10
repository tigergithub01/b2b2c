<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\SysArticleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-article-search">
	
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
	
	    <?php //  $form->field($model, 'id') ?>

    <?php //  $form->field($model, 'type_id') ?>

    <?= $form->field($model, 'title') ?>

    <?php //  $form->field($model, 'code') ?>

    <?php // // $form->field($model, 'issue_date') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'issue_user_id') ?>

    <?php // echo $form->field($model, 'is_show') ?>

    <?php // echo $form->field($model, 'is_sys_flag') ?>

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Module::t('app', 'Create Sys Article'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
