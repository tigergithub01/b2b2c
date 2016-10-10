<?php
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="sys-article-view">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title" style="visibility: visible;"><?php echo 'api-test';?></h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool"
					data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>

		<div class="box-body">
			<div class="form-group">
				<?php echo Html::button('商家用户协议',['id'=>'btn_register_agreement','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-article/view'])]);?>
				<?php echo Html::button('广告图',['id'=>'btn_sys_ad_info','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-ad-info/index'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('短信验证码',['id'=>'btn_get_sms_code','class' => 'btn btn-primary','url'=>Url::to(['/vip/member/system/sms/index'])]);?>
				<?php echo Html::button('会员登录',['id'=>'btn_vip_login','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/system/login/index'])]);?>
				<?php echo Html::button('登录后修改密码',['id'=>'btn_vip_modify_pwd','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/system/modify-pwd/index'])]);?>
				<?php echo Html::button('会员注册',['id'=>'btn_vip_register','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/system/register/index'])]);?>	
				<?php echo Html::button('找回密码',['id'=>'btn_vip_forgot_pwd','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/system/login/forgot-pwd'])]);?>
				<?php echo Html::button('注销登陆',['id'=>'btn_vip_login_out','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/system/login-out/index'])]);?>
			</div>
		</div>
			
			
    	</div>
    	

</div>

<?php 
$this->registerJsFile("js/admin/apiTest.js",['depends' => [\yii\web\JqueryAsset::className()]])
?>
