<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\merchant\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Product */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Product'),
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['update-service']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-update">
	
	
   <div class="product-form">

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
	    
	    	<?php echo $form->errorSummary($model);?>
	
		    <div class="box-body">
		    
		     <?= $form->field($model, 'market_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sale_price')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'deposit_amount')->textInput(['maxlength' => true]) ?>
	
			</div>
		
		    <div class="box-footer form-group">
		        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create_Save') : Yii::t('app', 'Update_Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		    </div>
	
	    	<?php ActiveForm::end(); ?>
		
		</div>
		
	</div>

</div>
