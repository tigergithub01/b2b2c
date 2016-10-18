<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\b2b2c\common\Constant;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Vip */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vip-form">

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
	    
	
	<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">基础信息</a></li>
              
              <?php if(!$model->isNewRecord){?>
              <li><a href="#tab_2" data-toggle="tab">营业信息</a></li>
              <li><a href="#tab_3" data-toggle="tab">个人信息</a></li>
              <?php }?>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
              	<?php include '_form_basic.php';?>
              </div>
              <!-- /.tab-pane -->
              <?php if(!$model->isNewRecord){?>
              <div class="tab-pane" id="tab_2">
                <?php include '_form_vip_org.php';?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <?php include '_form_vip_extend.php';?>
              </div>
              <!-- /.tab-pane -->
              <?php }?>
            </div>
            <!-- /.tab-content -->
          </div>
          
          <?php ActiveForm::end(); ?>
	
</div>
