<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysAdInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-ad-info-form">

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
	     <?php echo $form->field($model, 'imageFile')->fileInput(['multiple' => false, 'accept' => 'image/*']); ?>
	     
	    <?php // $form->field($model, 'img_url')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'thumb_url')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'img_original')->textInput(['maxlength' => true]) ?>
    
    <?php if(!($model->isNewRecord)) {?>
    	<div class="form-group">
    		<?= Html::activeLabel($model, 'img_url',['class'=>'col-lg-2 control-label']) ?>
			<div class="col-lg-6">
				<?= Html::a($model->img_url,Yii::$app->request->hostInfo . '/' . $model->img_url,['target'=>'_blank',])?>
			</div>
		</div>
		<div class="form-group">
    		<?= Html::activeLabel($model, 'thumb_url',['class'=>'col-lg-2 control-label']) ?>
			<div class="col-lg-6">
				<?= Html::a($model->thumb_url,Yii::$app->request->hostInfo . '/' . $model->thumb_url,['target'=>'_blank',])?>
			</div>
		</div>
		<div class="form-group">
    		<?= Html::activeLabel($model, 'img_original',['class'=>'col-lg-2 control-label']) ?>
			<div class="col-lg-6">
				<?= Html::a($model->img_original,Yii::$app->request->hostInfo . '/' . $model->img_original,['target'=>'_blank',])?>
			</div>
		</div>
    <?php }?>
    	

    <?= $form->field($model, 'sequence_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'redirect_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'width')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
