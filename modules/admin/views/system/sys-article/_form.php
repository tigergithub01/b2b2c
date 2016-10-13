<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ijackua\lepture\Markdowneditor;
use yii\helpers\ArrayHelper;
use kucha\ueditor\UEditor;
use app\models\b2b2c\common\Constant;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysArticle */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
	//ijackua\lepture\MarkdowneditorAssets::register($this);
?>

<div class="sys-article-form">

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
	    <?php //echo $form->field($model, 'type_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'issue_date')->textInput(); ?>
    
    <?= $form->field($model, 'issue_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    <?php //echo $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    
    <?php //echo $form->field($model, 'content')->widget(Markdowneditor::className(), []); ?>
                    
    <?= $form->field($model, 'content')->widget(UEditor::className(), [
    		'clientOptions' => ['readonly'=>false,],
                    ]) ?>                
    

    <?php //echo $form->field($model, 'issue_user_id')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'is_show')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'is_show')->dropDownList(ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')])?>

    <?php // $form->field($model, 'is_sys_flag')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'is_sys_flag')->dropDownList(ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')])?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
