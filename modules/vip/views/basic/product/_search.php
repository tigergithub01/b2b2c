<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\vip\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">
	
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><?= Yii::t('app', 'Search_criteria') ?></h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>
	
	
	    <?php $form = ActiveForm::begin([
	        'action' => ['index'],
	        'method' => 'get',
	        'options' => ['class' => 'form-horizontal'],
	        'fieldConfig' => [ 
					'template' => "{label}\n<div class=\"col-sm-6\">{input}</div>\n<div class=\"col-sm-3\">{error}</div>",
					'labelOptions' => [ 
							'class' => 'col-sm-3 control-label' 
					], 
					'options'=>['class' => 'form-group col-sm-6'], 
			],
	    ]); ?>
	    
	    <div class="box-body">
	
	    <?php //echo $form->field($model, 'id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'name') ?>

    <?php //echo $form->field($model, 'type_id') ?>
    
    <?= $form->field($model, 'type_id')->dropDownList(\yii\helpers\ArrayHelper::map($ptypeList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php //echo  $form->field($model, 'brand_id') ?>
    
    <?= $form->field($model, 'brand_id')->dropDownList(\yii\helpers\ArrayHelper::map($pbrandList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'market_price') ?>

    <?php // echo $form->field($model, 'sale_price') ?>

    <?php // echo $form->field($model, 'deposit_amount') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'is_on_sale') ?>

    <?php // echo $form->field($model, 'is_hot') ?>

    <?php // echo $form->field($model, 'audit_status') ?>

    <?php // echo $form->field($model, 'audit_user_id') ?>

    <?php // echo $form->field($model, 'audit_date') ?>

    <?php // echo $form->field($model, 'stock_quantity') ?>

    <?php // echo $form->field($model, 'safety_quantity') ?>

    <?php // echo $form->field($model, 'can_return_flag') ?>

    <?php // echo $form->field($model, 'return_days') ?>

    <?php // echo $form->field($model, 'return_desc') ?>

    <?php // echo $form->field($model, 'cost_price') ?>

    <?php // echo $form->field($model, 'vip_id') ?>
    
    <?= $form->field($model, 'vip_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipList, "id", "vip_name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'keywords') ?>

    <?php // echo $form->field($model, 'is_free_shipping') ?>

    <?php // echo $form->field($model, 'give_integral') ?>

    <?php // echo $form->field($model, 'rank_integral') ?>

    <?php // echo $form->field($model, 'integral') ?>

    <?php // echo $form->field($model, 'relative_module') ?>

    <?php // echo $form->field($model, 'bonus') ?>

    <?php // echo $form->field($model, 'product_weight') ?>

    <?php // echo $form->field($model, 'product_weight_unit') ?>

    <?php // echo $form->field($model, 'product_group_id') ?>

    <?php // echo $form->field($model, 'img_url') ?>

    <?php // echo $form->field($model, 'thumb_url') ?>

    <?php // echo $form->field($model, 'img_original') ?>

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?php // echo Html::a(Module::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
