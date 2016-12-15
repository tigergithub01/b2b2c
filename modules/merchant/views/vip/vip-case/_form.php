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
						'initialPreview'=> $initialPreviewCover,
						'initialPreviewAsData'=>true,
						'overwriteInitial'=>true,
						'showCaption' => false,
						'showRemove' => false,
						'showUpload' => false,
				],
		])->label($model->attributeLabels()['imageFile']. \Yii::t('app', 'upload_picture_tips'));
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
						'initialPreview'=>$initialPreview,
						'initialPreviewConfig' => $initialPreviewConfig,
						'initialPreviewAsData'=>true,
						'overwriteInitial'=>false,
						'showCaption' => false,
						'fileUrlName' => 'VipCase[imageUrls][]',
						'showRemove' => false,
						'maxFileCount' => 5,
						'showBrowse'=> true,
// 						'browseLabel' =>  '选择图片（图片分辨率1024*681）',
						'showUpload' => false,
						'browseOnZoneClick' => true,// 展示图片区域是否可点击选择多文件
						'uploadUrl' => ($model->isNewRecord?\yii\helpers\Url::toRoute(['common-upload','id'=>$model->id]):\yii\helpers\Url::toRoute(['upload','id'=>$model->id])),
						// 如果要设置具体图片上的移除、上传和展示按钮，需要设置该选项
						'fileActionSettings' => [
								// 设置具体图片的查看属性为false,默认为true
								'showZoom' => true,
								// 设置具体图片的上传属性为true,默认为true
								'showUpload' => true,
								// 设置具体图片的移除属性为true,默认为true
								'showRemove' => false,
						],
				],
				// 一些事件行为
				'pluginEvents' => [
						// 上传成功后的回调方法，需要的可查看data后再做具体操作，一般不需要设置
						"filedeleted" => "function (event, key) {
							console.log('deleted Key = ' + key);
				        }",
						"change" => "function (event) {
				            console.log('change');
				        }",
						"fileselect" => "function (event, numFiles, label) {
				            console.log('---fileselect start---');
							console.log(label);
							console.log(event);
							console.log(numFiles);
							console.log('---fileselect end---');
							//$(event.target).fileinput('upload');	
				        }",
						"filebatchselected" => "function (event, files) {
				            console.log('filebatchselected');
							console.log(event);
							console.log(files);
							//$('.field-vipcase-imagefiles .fileinput-upload-button').click();
							//for(i=0;i<numFiles;i++){
								//$(event.target).fileinput('upload');
							//}
							$(event.target).fileinput('upload');
							//$('#input-id').fileinput('upload');
				        }",
						"fileloaded" => "function (event, file, previewId, index, reader) {
				            console.log('-- fileloaded start -- ');
						 	console.log(file);
							console.log(event);
							console.log(previewId);
							console.log(index);
							console.log(reader);
							console.log('---fileloaded end---');
				        }",
						"fileimageloaded" => "function (event, previewId) {
				            console.log('-- fileimageloaded start -- ');
							console.log(event);
							console.log(previewId);
							console.log('---fileimageloaded end---');
				        }",
						"fileuploaded" => "function (event, data, previewId, index) {
				            var form = data.form, files = data.files, extra = data.extra,
						    response = data.response, reader = data.reader;
						    console.log('---fileuploaded start---');
						 	console.log(data);
							console.log(event);
							console.log(previewId);
							console.log(index);
							console.log('---fileuploaded end---');
				        }",
						"filebatchuploadcomplete" => "function (event, files, extra) {
							console.log('---filebatchuploadcomplete start---');
							console.log(event);
							console.log(files);
							console.log(extra);
							console.log('---filebatchuploadcomplete end---');
				        }",
				],
		])->label($model->attributeLabels()['imageFiles']. \Yii::t('app', 'upload_picture_tips'));
	?>
    

		</div>
		
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
	
	
</div>
