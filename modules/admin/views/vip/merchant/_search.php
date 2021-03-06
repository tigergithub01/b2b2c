<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\VipSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-search">
	
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

    <?= $form->field($model, 'vip_id') ?>

    <?php //echo $form->field($model, 'merchant_flag') ?>

    <?= $form->field($model, 'vip_name') ?>

    <?php //echo $form->field($model, 'last_login_date') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'parent_id') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'mobile_verify_flag') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'email_verify_flag') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'register_date') ?>

    <?php // echo $form->field($model, 'rank_id') ?>

    <?php // echo $form->field($model, 'audit_status') ?>
    
    <?= $form->field($model, 'audit_status')->dropDownList(\yii\helpers\ArrayHelper::map($auditStatusList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'audit_user_id') ?>

    <?php // echo $form->field($model, 'audit_date') ?>

    <?php // echo $form->field($model, 'audit_memo') ?>

    <?php // echo $form->field($model, 'vip_type_id') ?>
    
    <?= $form->field($model, 'vip_type_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipTypeList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'nick_name') ?>

    <?php // echo $form->field($model, 'wedding_date') ?>

    <?php // echo $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'img_url') ?>

    <?php // echo $form->field($model, 'thumb_url') ?>

    <?php // echo $form->field($model, 'img_original') ?>

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Module::t('app', 'Create Merchant'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
