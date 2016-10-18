<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\b2b2c\common\Constant;

/* @var $this yii\web\View */
/* @var $vipOrganization app\models\b2b2c\Vip */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-form">

	   
    
    	<?php //echo $form->errorSummary($vipOrganization);?>

	    <div class="box-body">
	    <?= $form->field($vipOrganization, 'name')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($vipOrganization, 'status')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($vipOrganization, 'status')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?= $form->field($vipOrganization, 'logo_img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipOrganization, 'logo_thumb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipOrganization, 'logo_img_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipOrganization, 'cover_img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipOrganization, 'cover_thumb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipOrganization, 'cover_img_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipOrganization, 'vip_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipOrganization, 'description')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($vipOrganization, 'country_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($vipOrganization, 'country_id')->dropDownList(\yii\helpers\ArrayHelper::map($countryList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($vipOrganization, 'province_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($vipOrganization, 'province_id')->dropDownList(\yii\helpers\ArrayHelper::map($proviceList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($vipOrganization, 'city_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($vipOrganization, 'city_id')->dropDownList(\yii\helpers\ArrayHelper::map($cityList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
	
	<?php // echo $form->field($vipOrganization, 'district_id')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($vipOrganization, 'district_id')->dropDownList(\yii\helpers\ArrayHelper::map($districtList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
	 
    <?php // echo $form->field($vipOrganization, 'audit_status')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($vipOrganization, 'audit_status')->dropDownList(\yii\helpers\ArrayHelper::map($auditStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo $form->field($vipOrganization, 'audit_user_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($vipOrganization, 'audit_user_id')->dropDownList(\yii\helpers\ArrayHelper::map($userList, "id", "user_id"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($vipOrganization, 'audit_date')->textInput() ?>
    
    <?= $form->field($vipOrganization, 'audit_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    <?= $form->field($vipOrganization, 'audit_memo')->textarea(['row' => 6]) ?>

    <?php // echo $form->field($vipOrganization, 'create_date')->textInput() ?>
    
    <?= $form->field($vipOrganization, 'create_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

    <?php // echo $form->field($vipOrganization, 'update_date')->textInput() ?>
    
    <?= $form->field($vipOrganization, 'update_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ]) ?>

   

    <?= $form->field($vipOrganization, 'address')->textarea(['row' => 6]) ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($vipOrganization->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $vipOrganization->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	
	
	
	
</div>
