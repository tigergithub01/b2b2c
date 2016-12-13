<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\b2b2c\common\Constant;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipBlog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-blog-form">

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
	    
	    <?php // echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	    
	<?php //echo $form->field($model, 'blog_type')->textInput(['maxlength' => true]) ?>
	    
	<?php // echo $form->field($model, 'blog_type')->dropDownList(\yii\helpers\ArrayHelper::map($vipBlogTypeList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
	
    <?php //echo $form->field($model, 'blog_flag')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'blog_flag')->dropDownList(\yii\helpers\ArrayHelper::map($blogFlagList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
    
    <?php //echo $form->field($model, 'vip_id')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'vip_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipList, "id", "vip_name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?php //echo $form->field($model, 'create_date')->textInput() ?>
    
    <?php /*echo $form->field($model, 'create_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ])*/ ?>

    <?php //echo $form->field($model, 'update_date')->textInput() ?>
    
    <?php /* $form->field($model, 'update_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ])*/ ?>

    <?php //echo $form->field($model, 'audit_user_id')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'audit_user_id')->dropDownList(\yii\helpers\ArrayHelper::map($sysUserList, "id", "user_id"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
 
    <?php //echo $form->field($model, 'audit_status')->textInput(['maxlength' => true]) ?>
    
    
    <?php // echo $form->field($model, 'audit_status')->dropDownList(\yii\helpers\ArrayHelper::map($auditStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'audit_date')->textInput() ?>
    
    <?php /* echo  $form->field($model, 'audit_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ])*/ ?>

    <?php // echo $form->field($model, 'audit_memo')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'status')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
	
	<?php echo $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>
	
		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '发布动态') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
