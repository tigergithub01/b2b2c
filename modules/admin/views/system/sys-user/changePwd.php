<?php

use yii\helpers\Html;
use app\modules\admin\Module;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysUser */

$this->title = Module::t('app', 'Change User Pwd') .'：' .$model->user_id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('app', 'Change User Pwd');
?>
<div class="sys-user-update">

    <div class="sys-user-form">

		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title" style="visibility: visible;"><?= Html::encode($this->title) ?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool"
						data-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
	
		    <?php $form = ActiveForm::begin([
		    	'options' => [ 
							'enctype' => 'multipart/form-data',
							'class' => 'form-horizontal',
					],
					'fieldConfig' => [ 
							'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
							'labelOptions' => [ 
									'class' => 'col-lg-2 control-label' 
							] 
					],
		    ]); ?>
	    
	    	<?php //echo $form->errorSummary($model);?>
	
		    <div class="box-body">
		    <?php //echo $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>
	
	   	 	<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
	   	 	
	   	 	<?= $form->field($model, 'confirm_pwd')->passwordInput(['maxlength' => true]) ?>
	
	
			</div>
		
		    <div class="box-footer form-group">
		        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		    </div>
	
	    	<?php ActiveForm::end(); ?>
		
		</div>
		
	</div>

</div>
