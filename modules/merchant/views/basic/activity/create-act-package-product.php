<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\merchant\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Activity */
/* @var $form yii\widgets\ActiveForm */

$this->title = Module::t('app', 'Create Act Package Product');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $activity->name, 'url' => ['view', 'id' => $model->act_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="act-package-product-form">

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
	    <?php // echo $form->field($model, 'act_id')->textInput(['maxlength' => true]) ?>
	    
	    <?php // $form->field($model, 'act_id')->dropDownList(\yii\helpers\ArrayHelper::map($activityList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'product_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'product_id')->dropDownList(\yii\helpers\ArrayHelper::map($productList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'package_price')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'quantity')->textInput() ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
