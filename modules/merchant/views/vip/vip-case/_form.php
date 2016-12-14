<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\b2b2c\common\Constant;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-case-form">

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
    
    	<?php // echo $form->errorSummary($model);?>

	    <div class="box-body">
	    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'type_id')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'type_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipCaseTypeList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'vip_id')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'vip_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipList, "id", "vip_name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
    

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?php //echo $form->field($model, 'create_date')->textInput() ?>
    
    <?php /* echo $form->field($model, 'create_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ])*/ ?>

    <?php //echo $form->field($model, 'update_date')->textInput() ?>
    
    <?php /* echo $form->field($model, 'update_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ])*/ ?>

    <?php //echo $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'status')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'audit_status')->textInput(['maxlength' => true]) ?>
    
    <?php //echo $form->field($model, 'audit_status')->dropDownList(\yii\helpers\ArrayHelper::map($auditStatList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'audit_user_id')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'audit_user_id')->dropDownList(\yii\helpers\ArrayHelper::map($sysUserList, "id", "user_id"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'audit_date')->textInput() ?>
    
    <?php /* echo $form->field($model, 'audit_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ])*/ ?>

    <?php // echo $form->field($model, 'audit_memo')->textarea(['rows' => 6]) ?>
	
	<?php //echo $form->field($model, 'imageFile')->fileInput(['multiple' => false, 'accept' => 'image/*']); ?>
	
	<?php 
		echo $form->field($model, 'imageFile')->widget(\kartik\file\FileInput::classname(), [
				'options' => ['accept' => 'image/*'],
				'pluginOptions' => [
						'initialPreview'=> $coverThumb,
						'initialPreviewAsData'=>true,
						'overwriteInitial'=>false,
						'showCaption' => true,
						'showRemove' => true,
						'showUpload' => false,
				],
		]);
	?>
	
	<?php /*if($model->cover_img_url) {?>
    	<div class="form-group">
    		<?= Html::activeLabel($model, 'cover_img_url',['class'=>'col-lg-2 control-label', 'style'=>'visibility:hidden;']) ?>
			<div class="col-lg-6">
				<a class="fancybox" href="<?php echo Yii::$app->request->hostInfo . '/' . $model->cover_img_url?>"><img width="200" height="200" src="<?php echo Yii::$app->request->hostInfo . '/' . $model->cover_thumb_url?>"></a>
			</div>
		</div>
    <?php }*/ ?>
    
    
    <?php // echo $form->field($model, 'cover_img_url')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'cover_thumb_url')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'cover_img_original')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'is_hot')->textInput(['maxlength' => true]) ?>
	
	<?php // echo $form->field($model, 'is_hot')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
	
    <?php //echo $form->field($model, 'case_flag')->textInput(['maxlength' => true]) ?>
    
    <?php //echo $form->field($model, 'case_flag')->dropDownList(\yii\helpers\ArrayHelper::map($caseFlagList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
	
	<?= $form->field($model, 'service_date')->widget(dosamigos\datepicker\DatePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_PICKER_FORMAT,
    			]
          ]) ?>
          
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
          
    <?= $form->field($model, 'market_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sale_price')->textInput(['maxlength' => true]) ?>
    
    <?php //echo $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>
    
    
    <?php 
		echo $form->field($model, 'imageFiles[]')->widget(\kartik\file\FileInput::classname(), [
				'options' => ['multiple' => true, 'accept' => 'image/*'],
				'pluginOptions' => [
						//'initialPreview'=>$vipCasePhotoThumbs,
						'initialPreviewConfig' => [
								['caption' => 'Moon.jpg', 'size' => '873727'],
								['caption' => 'Earth.jpg', 'size' => '1287883'],
						],
						'initialPreviewAsData'=>true,
						'overwriteInitial'=>false,
						'showCaption' => true,
						'showRemove' => true,
						'showUpload' => false,
						'browseOnZoneClick' => true,// 展示图片区域是否可点击选择多文件
						//'uploadUrl' => \yii\helpers\Url::to(['/site/file-upload']),
						// 如果要设置具体图片上的移除、上传和展示按钮，需要设置该选项
						'fileActionSettings' => [
								// 设置具体图片的查看属性为false,默认为true
								'showZoom' => false,
								// 设置具体图片的上传属性为true,默认为true
								'showUpload' => false,
								// 设置具体图片的移除属性为true,默认为true
								'showRemove' => true,
						],
				],
				// 一些事件行为
				'pluginEvents' => [
						// 上传成功后的回调方法，需要的可查看data后再做具体操作，一般不需要设置
						"filedeleted" => "function (event, key) {
				            console.info('deleted.');
				        }",
				],
		])->label("案例相册（按住CTR键多选）");
	?>
    

		</div>
		
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
	
	
</div>
