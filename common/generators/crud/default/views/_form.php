<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title" style="visibility: visible;"><?='<?= '?>Html::encode($this->title) ?></h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool"
					data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>

	    <?= "<?php " ?>$form = ActiveForm::begin([
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
    
    	<?='<?php '?>//echo $form->errorSummary($model);?>

	    <div class="box-body">
	<?php foreach ($generator->getColumnNames() as $attribute) {
	    if (in_array($attribute, $safeAttributes)) {
	        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
	    }
	} ?>
		</div>
	
	    <div class="box-footer form-group">
	        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Create_Save') ?> : <?= $generator->generateString('Update_Save') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    	<?= "<?php " ?>ActiveForm::end(); ?>
	
	</div>
	
</div>
