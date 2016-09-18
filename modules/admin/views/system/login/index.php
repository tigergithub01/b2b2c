<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use Yii\web\View;
use yii\captcha\Captcha;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Module::t('app', 'admin_sign_in');

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
            ->field($model, 'user_id', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('user_id')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
            
        <?= $form->field($model, 'verify_code')
        			->label(false)
        			->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-6">{image}</div></div>',
        				'options' => ['placeholder' => $model->getAttributeLabel('verify_code'),'class'=>'form-control',],	
        				'captchaAction' => '/site/captcha',
                    ]) ?>     
            

        <div class="row">
            <div class="col-xs-8 icheck">
                <?= $form->field($model, 'remember_me')->checkbox(['label'=>'记住密码']) ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('登陆', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
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
?>
