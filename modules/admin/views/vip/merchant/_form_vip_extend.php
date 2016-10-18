<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\b2b2c\common\Constant;

/* @var $this yii\web\View */
/* @var $vipExtend app\models\b2b2c\Vip */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-form">


	   
    
    	<?php //echo $form->errorSummary($vipExtend);?>

	    <div class="box-body">
	    <?= $form->field($vipExtend, 'vip_id')->textInput(['maxlength' => true, 'readonly' => 'true']) ?>

    <?= $form->field($vipExtend, 'real_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'id_card_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'id_card_img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'id_card_thumb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'id_card_img_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'id_back_img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'id_back_thumb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'id_back_img_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'bl_img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'bl_thumb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'bl_img_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'bank_account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'bank_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'bank_addr')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($vipExtend, 'audit_status')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($vipExtend, 'audit_status')->dropDownList(\yii\helpers\ArrayHelper::map($auditStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($vipExtend, 'audit_user_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($vipExtend, 'audit_user_id')->dropDownList(\yii\helpers\ArrayHelper::map($userList, "id", "user_id"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($vipExtend, 'audit_date')->textInput() ?>
    
    <?= $form->field($vipExtend, 'audit_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    <?= $form->field($vipExtend, 'audit_memo')->textarea(['rows' => 6]) ?>

    <?php // echo  $form->field($vipExtend, 'create_date')->textInput() ?>
    
    <?= $form->field($vipExtend, 'create_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    <?php // echo  $form->field($vipExtend, 'update_date')->textInput() ?>
    
    <?= $form->field($vipExtend, 'update_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($vipExtend->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $vipExtend->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	
	
	
	
</div>
