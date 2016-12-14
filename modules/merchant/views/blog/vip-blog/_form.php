<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\b2b2c\common\Constant;
use yii\helpers\Url;

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
	
	<?php //echo $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>
	
	
	<?php 
		echo $form->field($model, 'imageFiles[]')->widget(\kartik\file\FileInput::classname(), [
				'options' => ['multiple' => true, 'accept' => 'image/*'],
				'pluginOptions' => [
						//'initialPreview'=>$vipCasePhotoThumbs,
						//'initialPreviewAsData'=>true,
						'overwriteInitial'=>false,
						'showCaption' => true,
						'showRemove' => true, //是否显示移除按钮，指input上面的移除按钮，非具体图片上的移除按钮
						'showUpload' => false,  // 是否显示上传按钮，指input上面的上传按钮，非具体图片上的上传按钮
						'showBrowse' => true, //是否显示[选择]按钮,指input上面的[选择]按钮,非具体图片上的上传按钮 
						'browseOnZoneClick' => true,// 展示图片区域是否可点击选择多文件
						// 如果要设置具体图片上的移除、上传和展示按钮，需要设置该选项
						'fileActionSettings' => [
								// 设置具体图片的查看属性为false,默认为true
								'showZoom' => false,
								// 设置具体图片的上传属性为true,默认为true
								'showUpload' => false,
								// 设置具体图片的移除属性为true,默认为true
								'showRemove' => true,
						],
						
						// 异步上传的接口地址设置
						//'uploadUrl' => \yii\helpers\Url::to(['/site/file-upload']),
						
						// 最少上传的文件个数限制
						//'minFileCount' => 1,
						// 最多上传的文件个数限制
						//'maxFileCount' => 10,
						
						// 异步上传需要携带的其他参数
						'uploadAsync' => true,
						
// 						'uploadExtraData' => [
// 								'album_id' => 20,
// 								'cat_id' => 'Nature'
// 						],
				],
				// 一些事件行为
				'pluginEvents' => [
						// 上传成功后的回调方法，需要的可查看data后再做具体操作，一般不需要设置
						"fileuploaded" => "function (event, file, previewId, index, reader) {
				            console.log(file);
				        }",
						'fileuploaderror' => "function (event, data, msg){
				            alert('图片上传失败');
				        }",
				],
				
		])->label("动态图片（按住CTR键多选）");
	?>
	
		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '发布动态') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
	
	</div>
	
</div>
