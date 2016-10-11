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
				<?php echo Html::textarea("test",null,['rows'=>10,'id'=>'txt_api_return','style'=>'width:100%;','placeholder'=>'执行结果'])?>
			
			</div>
		
			<div class="form-group">
				
				<?php echo Html::button('广告图',['id'=>'btn_sys_ad_info','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-ad-info/index'])]);?>
				<?php echo Html::button('地区信息',['id'=>'btn_sys_region','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-region/index'])]);?>
				<?php echo Html::button('地区信息（根据商家获取）',['id'=>'btn_sys_region_merchant','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-region/merchant-regions'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('发送短信验证码',['id'=>'btn_get_sms_code','class' => 'btn btn-primary','url'=>Url::to(['/vip/member/system/sms/index'])]);?>
				<?php echo Html::button('验证短信验证码',['id'=>'btn_verify_sms_code','class' => 'btn btn-primary','url'=>Url::to(['/vip/member/system/sms/verify-sms-code'])]);?>
			</div>
			
			<div class="form-group">	
				<?php echo Html::button('会员登录',['id'=>'btn_vip_login','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/system/login/index'])]);?>
				<?php echo Html::button('登录后修改密码',['id'=>'btn_vip_modify_pwd','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/system/modify-pwd/index'])]);?>
				<?php echo Html::button('会员注册',['id'=>'btn_vip_register','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/system/register/index'])]);?>	
				<?php echo Html::button('找回密码',['id'=>'btn_vip_forgot_pwd','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/system/login/forgot-pwd'])]);?>
				<?php echo Html::button('注销登陆',['id'=>'btn_vip_login_out','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/system/login-out/index'])]);?>
				<?php echo Html::button('更新会员信息',['id'=>'btn_vip_update','class' => 'btn btn-primary','url'=>Url::to(['/debug'])]);?>
				<?php echo Html::button('获取会员信息',['id'=>'btn_vip_update','class' => 'btn btn-primary','url'=>Url::to(['/debug'])]);?>
			</div>
			
			
			<div class="form-group">
				<?php echo Html::button('ANDROID 客户端下载',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
				<?php echo Html::button('ANDROID 最新版本检测',['id'=>'btn_andorid_app_release','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-app-release/index','code'=>'wedding_android'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('案例列表',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
				<?php echo Html::button('案例详情',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('商户列表',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
				<?php echo Html::button('商户详情',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('组团服务列表',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
				<?php echo Html::button('组团服务详情',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('我的消息',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
				<?php echo Html::button('我的关注',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
				<?php echo Html::button('我的收藏',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
				<?php echo Html::button('商家用户协议',['id'=>'btn_register_agreement','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-article/view'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('我的订单列表',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
				<?php echo Html::button('订单详情',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
				<?php echo Html::button('服务咨询',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
				<?php echo Html::button('订单提交',['id'=>'btn_register_agreement','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-article/view'])]);?>
			</div>
			
		</div>
			
			
    	</div>
    	

</div>

<?php 
$this->registerJsFile("js/admin/apiTest.js",['depends' => [\yii\web\JqueryAsset::className()]])
?>
