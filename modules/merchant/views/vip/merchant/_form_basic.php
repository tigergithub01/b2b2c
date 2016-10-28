<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\b2b2c\common\Constant;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Vip */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-form">


	   
    
    	<?php echo $form->errorSummary([$model,$vipOrganization,$vipExtend, $product]);?>

	    <div class="box-body">
	    <?= $form->field($model, 'vip_id')->textInput(['maxlength' => true, 'readonly'=>true]) ?>

    <?php //echo $form->field($model, 'merchant_flag')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'merchant_flag')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($model, 'vip_name')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'last_login_date')->textInput(['readonly'=>true]) ?>

    <?php if($model->isNewRecord){?>
    	<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?php }?>

    <?php //echo $form->field($model, 'parent_id')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'mobile_verify_flag')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'mobile_verify_flag')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'email_verify_flag')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'email_verify_flag')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'status')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'register_date')->textInput() ?>
    
    <?php /* echo $form->field($model, 'register_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ])*/ ?>

    <?php //echo $form->field($model, 'rank_id')->textInput(['maxlength' => true]) ?>
    
    <?php //echo $form->field($model, 'rank_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipRankList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'audit_status')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'audit_status')->dropDownList(\yii\helpers\ArrayHelper::map($auditStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'audit_user_id')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'audit_user_id')->dropDownList(\yii\helpers\ArrayHelper::map($userList, "id", "user_id"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($model, 'audit_date')->textInput() ?>
    
    <?php /* echo $form->field($model, 'audit_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ])*/ ?>

    <?php // echo $form->field($model, 'audit_memo')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'vip_type_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'vip_type_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipTypeList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt'), 'disabled'=>true, ]) ?>

    <?php //echo $form->field($model, 'sex')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'sex')->dropDownList(\yii\helpers\ArrayHelper::map($sexList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'nick_name')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'wedding_date')->textInput() ?>
    
    <?php /*$form->field($model, 'wedding_date')->widget(dosamigos\datepicker\DatePicker::className(), [
//     		'options' => ['readonly'=>true],
    		'language' => Yii::$app->language,
//     		'template' => '{input}{addon}',
    		'clientOptions' => [
    				'autoclose' => true,
    				//'format' => 'yyyy-mm-dd HH:ii:ss',
    				'format' => Constant::DATE_PICKER_FORMAT,
//     				'todayBtn' => true,
    			]
          ])*/ ?>

    <?php //echo $form->field($model, 'birthday')->textInput() ?>
    
    <?php /* $form->field($model, 'birthday')->widget(\yii\jui\DatePicker::className(), [
    		'dateFormat' => 'yyyy-MM-dd',
    		'options' => ['readonly'=>true]
                    ]) */?>
    
    <?php /*$form->field($model, 'birthday')->widget(\dosamigos\datepicker\DatePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_PICKER_FORMAT,
    			]
          ])*/ ?>
	
	<?php echo $form->field($model, 'imageFile')->fileInput(['multiple' => false, 'accept' => 'image/*']); ?>
	
	<?php if($model->img_url) {?>
    	<div class="form-group">
    		<?= Html::activeLabel($model, 'img_url',['class'=>'col-lg-2 control-label', 'style'=>'visibility:hidden;']) ?>
			<div class="col-lg-6">
				<?php if($model->img_url) {?>
				<a class="fancybox" href="<?php echo Yii::$app->request->hostInfo . '/' . $model->img_url?>"><img width="200" height="200" src="<?php echo Yii::$app->request->hostInfo . '/' . $model->thumb_url?>"></a>
				<?php }?>
			</div>
		</div>
    <?php }?>
    
    <?php // echo $form->field($model, 'img_url')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'thumb_url')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'img_original')->textInput(['maxlength' => true]) ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	
	
	
	
</div>
