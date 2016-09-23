<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use Yii\web\View;
use yii\captcha\Captcha;
use app\modules\vip\Module;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Module::t('app', 'forgot_pwd');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><?php echo $this->title;?></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <!-- <p class="login-box-msg">Sign in to start your session</p> -->

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => true]); ?>

        <?= $form
            ->field($model, 'vip_id', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('vip_id')]) ?>
            
        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>    
            
        <?= $form
            ->field($model, 'confirm_pwd', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('confirm_pwd')]) ?>
            
        <?= $form->field($model, 'verify_code')
        			->label(false)
        			->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-sm-6">{input}</div><div class="col-sm-6">{image}</div></div>',
        				'options' => ['placeholder' => $model->getAttributeLabel('verify_code'),'class'=>'form-control',],	
        				'captchaAction' => '/site/captcha',
                    ]) ?>     
         
         <?= $form->field($model, 'sms_code',['template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-6"><input type="button" url="'.Url::to(['system/sms/index']).'" value="获取验证码" class="btn btn-block btn-flat btn_sms"/></div></div>{error}',])
        			->label(false)
        			->textInput([
        				'placeholder' => $model->getAttributeLabel('sms_code'),
                    ]) ?>   

        <div class="row">
            <!-- /.col -->
            <div class="col-xs-12">
                <?= Html::submitButton('确认修改', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>
		
        <?php ActiveForm::end(); ?>
        
       <!--  <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a> -->

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->

<?php 
	$this->registerJs("$(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });",View::POS_END);
	
  $this->registerJsFile("js/common/sms.js",['depends' => [\yii\web\JqueryAsset::className()]])
	
?>
