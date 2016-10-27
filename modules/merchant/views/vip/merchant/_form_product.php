<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\b2b2c\common\Constant;

/* @var $this yii\web\View */
/* @var $product app\models\b2b2c\Vip */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-form">


	   
    
    	<?php //echo $form->errorSummary($product);?>

	    <div class="box-body">
	    <?php // echo $form->field($product, 'vip_id')->textInput(['maxlength' => true, 'readonly' => 'true']) ?>

	
	 <?= $form->field($product, 'market_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($product, 'sale_price')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($product, 'deposit_amount')->textInput(['maxlength' => true]) ?>

		</div>
	
	    <div class="box-footer form-group">
	        <?= Html::submitButton($product->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $product->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	
	
	
	
</div>
