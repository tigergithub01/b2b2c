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
	    <?php // echo $form->field($vipExtend, 'vip_id')->textInput(['maxlength' => true, 'readonly' => 'true']) ?>

    <?= $form->field($vipExtend, 'real_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'id_card_no')->textInput(['maxlength' => true]) ?>

    
    <?php // echo $form->field($vipExtend, 'id_card_img_url')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($vipExtend, 'id_card_thumb_url')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($vipExtend, 'id_card_img_original')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($vipExtend, 'imageFileIdCard')->fileInput(['multiple' => false, 'accept' => 'image/*']); ?>
    
    <?php if(($vipExtend->id_card_img_url)) {?>
    	<div class="form-group">
    		<?= Html::activeLabel($vipExtend, 'id_card_img_url',['class'=>'col-lg-2 control-label', 'style'=>'visibility:hidden;']) ?>
			<div class="col-lg-6">
				<?php if($model->img_url) {?>
				<a class="fancybox" href="<?php echo Yii::$app->request->hostInfo . '/' . $vipExtend->id_card_img_url?>"><img width="200" height="200" src="<?php echo Yii::$app->request->hostInfo . '/' . $vipExtend->id_card_thumb_url?>"></a>
				<?php }?>
			</div>
		</div>
    <?php }?>
	
	<?php if((false)) {?>
    	<div class="form-group">
    		<?= Html::activeLabel($vipExtend, 'id_card_img_url',['class'=>'col-lg-2 control-label']) ?>
			<div class="col-lg-6">
				<?= Html::a($vipExtend->id_card_img_url,Yii::$app->request->hostInfo . '/' . $vipExtend->id_card_img_url,['target'=>'_blank',])?>
			</div>
		</div>
		<div class="form-group">
    		<?= Html::activeLabel($vipExtend, 'id_card_thumb_url',['class'=>'col-lg-2 control-label']) ?>
			<div class="col-lg-6">
				<?= Html::a($vipExtend->id_card_thumb_url,Yii::$app->request->hostInfo . '/' . $vipExtend->id_card_thumb_url,['target'=>'_blank',])?>
			</div>
		</div>
		<div class="form-group">
    		<?= Html::activeLabel($vipExtend, 'id_card_img_original',['class'=>'col-lg-2 control-label']) ?>
			<div class="col-lg-6">
				<?= Html::a($vipExtend->id_card_img_original,Yii::$app->request->hostInfo . '/' . $vipExtend->id_card_img_original,['target'=>'_blank',])?>
			</div>
		</div>
    <?php }?>
    

    <?php // echo $form->field($vipExtend, 'id_back_img_url')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($vipExtend, 'id_back_thumb_url')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($vipExtend, 'id_back_img_original')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($vipExtend, 'imageFileIdCardBack')->fileInput(['multiple' => false, 'accept' => 'image/*']); ?>
	
	<?php if(($vipExtend->id_back_img_url)) {?>
    	<div class="form-group">
    		<?= Html::activeLabel($vipExtend, 'id_back_img_url',['class'=>'col-lg-2 control-label', 'style'=>'visibility:hidden;']) ?>
			<div class="col-lg-6">
				<?php if($model->img_url) {?>
				<a class="fancybox" href="<?php echo Yii::$app->request->hostInfo . '/' . $vipExtend->id_back_img_url?>"><img width="200" height="200" src="<?php echo Yii::$app->request->hostInfo . '/' . $vipExtend->id_back_thumb_url?>"></a>
				<?php }?>
			</div>
		</div>
    <?php }?>
    
	<?php if((false)) {?>
    	<div class="form-group">
    		<?= Html::activeLabel($vipExtend, 'id_back_img_url',['class'=>'col-lg-2 control-label']) ?>
			<div class="col-lg-6">
				<?= Html::a($vipExtend->id_back_img_url,Yii::$app->request->hostInfo . '/' . $vipExtend->id_back_img_url,['target'=>'_blank',])?>
			</div>
		</div>
		<div class="form-group">
    		<?= Html::activeLabel($vipExtend, 'id_back_thumb_url',['class'=>'col-lg-2 control-label']) ?>
			<div class="col-lg-6">
				<?= Html::a($vipExtend->id_back_thumb_url,Yii::$app->request->hostInfo . '/' . $vipExtend->id_back_thumb_url,['target'=>'_blank',])?>
			</div>
		</div>
		<div class="form-group">
    		<?= Html::activeLabel($vipExtend, 'id_back_img_original',['class'=>'col-lg-2 control-label']) ?>
			<div class="col-lg-6">
				<?= Html::a($vipExtend->id_back_img_original,Yii::$app->request->hostInfo . '/' . $vipExtend->id_back_img_original,['target'=>'_blank',])?>
			</div>
		</div>
    <?php }?>
    

    <?php //echo $form->field($vipExtend, 'bl_img_url')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($vipExtend, 'bl_thumb_url')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($vipExtend, 'bl_img_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'bank_account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'bank_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($vipExtend, 'bank_addr')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($vipExtend, 'audit_status')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($vipExtend, 'audit_status')->dropDownList(\yii\helpers\ArrayHelper::map($auditStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($vipExtend, 'audit_user_id')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($vipExtend, 'audit_user_id')->dropDownList(\yii\helpers\ArrayHelper::map($userList, "id", "user_id"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($vipExtend, 'audit_date')->textInput() ?>
    
    <?php /* echo $form->field($vipExtend, 'audit_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ])*/ ?>

    <?php // echo $form->field($vipExtend, 'audit_memo')->textarea(['rows' => 6]) ?>

    <?php // echo  $form->field($vipExtend, 'create_date')->textInput() ?>
    
    <?php /* echo $form->field($vipExtend, 'create_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ])*/ ?>

    <?php // echo  $form->field($vipExtend, 'update_date')->textInput() ?>
    
    <?php /* echo $form->field($vipExtend, 'update_date')->widget(dosamigos\datetimepicker\DateTimePicker::className(), [
    		'language' => Yii::$app->language,
    		'clientOptions' => [
    				'autoclose' => true,
    				'format' => Constant::DATE_TIME_PICKER_FORMAT,
    				'todayBtn' => true,
    			]
          ])*/ ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($vipExtend->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $vipExtend->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	
	
	
	
</div>
