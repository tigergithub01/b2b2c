<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\search\VipCaseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-case-search">
	
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

    <?= $form->field($model, 'name') ?>

    <?php //echo $form->field($model, 'type_id') ?>

    <?= $form->field($model, 'type_id')->dropDownList(\yii\helpers\ArrayHelper::map($vipCaseTypeList, "id", "name"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>
    
    <?php //echo $form->field($model, 'vip_id') ?>
    
    <?= $form->field($model, 'vip_name') ?>
    
    <?php // echo $form->field($model, 'vip_no') ?>

    <?php //echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'update_date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'audit_status') ?>
    
    <?= $form->field($model, 'audit_status')->dropDownList(\yii\helpers\ArrayHelper::map($auditStatList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'audit_user_id') ?>

    <?php // echo $form->field($model, 'audit_date') ?>

    <?php // echo $form->field($model, 'audit_memo') ?>

    <?php // echo $form->field($model, 'cover_img_url') ?>

    <?php // echo $form->field($model, 'cover_thumb_url') ?>

    <?php // echo $form->field($model, 'cover_img_original') ?>

    <?php // echo $form->field($model, 'is_hot') ?>
    
    <?= $form->field($model, 'is_hot')->dropDownList(\yii\helpers\ArrayHelper::map($yesNoList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'case_flag') ?>
    
    <?php //echo $form->field($model, 'case_flag')->dropDownList(\yii\helpers\ArrayHelper::map($caseFlagList, "id", "param_val"), ['prompt' => Yii::t('app', 'select_prompt')]) ?>

    <?php // echo $form->field($model, 'market_price') ?>

    <?php // echo $form->field($model, 'sale_price') ?>

	    
	    </div>
	    
	    <div class="box-footer clearfix form-group search_box">
	    	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
	    	<?= Html::a(Module::t('app', 'Create Vip Case'), ['create'], ['class' => 'btn btn-success']) ?>
	    </div>
	
	    <?php ActiveForm::end(); ?>
    </div>

</div>
