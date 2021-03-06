<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\VipExtendSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-extend-search">
	
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
	
	    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'vip_id') ?>

    <?= $form->field($model, 'real_name') ?>

    <?= $form->field($model, 'id_card_no') ?>

    <?= $form->field($model, 'id_card_img_url') ?>

    <?php // echo $form->field($model, 'id_card_thumb_url') ?>

    <?php // echo $form->field($model, 'id_card_img_original') ?>

    <?php // echo $form->field($model, 'id_back_img_url') ?>

    <?php // echo $form->field($model, 'id_back_thumb_url') ?>

    <?php // echo $form->field($model, 'id_back_img_original') ?>

    <?php // echo $form->field($model, 'bl_img_url') ?>

    <?php // echo $form->field($model, 'bl_thumb_url') ?>

    <?php // echo $form->field($model, 'bl_img_original') ?>

    <?php // echo $form->field($model, 'bank_account') ?>

    <?php // echo $form->field($model, 'bank_name') ?>

    <?php // echo $form->field($model, 'bank_number') ?>

    <?php // echo $form->field($model, 'bank_addr') ?>

    <?php // echo $form->field($model, 'audit_status') ?>

    <?php // echo $form->field($model, 'audit_user_id') ?>

    <?php // echo $form->field($model, 'audit_date') ?>

    <?php // echo $form->field($model, 'audit_memo') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'update_date') ?>

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Yii::t('app', 'Create Vip Extend'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
