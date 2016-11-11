<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\b2b2c\common\Constant;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysAppRelease */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-app-release-form">

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
	    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ver_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'upgrade_desc')->textarea(['rows' => 6]) ?>

    <?php //echo $form->field($model, 'force_upgrade')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'force_upgrade')->dropDownList(ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')])?>

    <?php // echo $form->field($model, 'issue_date')->textInput() ?>
    
    <?= $form->field($model, 'issue_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    <?php // echo $form->field($model, 'issue_user_id')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'app_path')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($model, 'uploadFile')->fileInput(['multiple' => false]); ?>

    <?php  // echo $form->field($model, 'app_info_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'app_info_id')->dropDownList(ArrayHelper::map($sysAppInfoList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')])?>
    
    

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '发布') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
