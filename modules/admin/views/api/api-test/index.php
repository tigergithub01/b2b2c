<?php
/* @var $this yii\web\View */

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
		
			<div class="form-group" style="border: 1px solid gray;padding:10px;">
				<?php echo Html::button('广告图',['id'=>'btn_sys_ad_info','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-ad-info/index'])]);?>
				<?php echo Html::button('地区信息',['id'=>'btn_sys_region','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-region/index'])]);?>
				<?php echo Html::button('地区信息（根据商家获取）',['id'=>'btn_sys_region_merchant','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-region/merchant-regions'])]);?>
				<?php echo Html::button('首页案例列表',['id'=>'btn_home_vip_case_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/vip-case/index'])]);?>
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
				<?php echo Html::button('更新会员信息',['id'=>'btn_vip_update','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/vip/vip/update'])]);?>
				<?php echo Html::button('获取会员信息',['id'=>'btn_vip_info','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/vip/vip/view'])]);?>
			</div>
			
			
			<div class="form-group">
				<?php echo Html::button('ANDROID 客户端下载',['id'=>'btn_andorid_download','class' => 'btn btn-primary','url'=>Url::to(['/vip/system/sys-app-info/index','code'=>'wedding_android'])]);?>
				<?php echo Html::button('ANDROID 最新版本检测',['id'=>'btn_andorid_app_release','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-app-release/index','code'=>'wedding_android'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('案例列表',['id'=>'btn_vip_case_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/vip-case/index'])]);?>
				<?php echo Html::button('案例详情',['id'=>'btn_vip_case_detail','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/vip-case/view'])]);?>
				<?php echo Html::button('收藏',['id'=>'btn_vip_collect_create','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/vip/vip-collect/create'])]);?>
				<?php echo Html::button('取消收藏',['id'=>'btn_vip_collect_delete','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/vip/vip-collect/delete'])]);?>
				<?php echo Html::button('收藏数量统计',['id'=>'btn_vip_collect_count','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/vip-collect/count'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('商户类别',['id'=>'btn_merchant_type_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/vip-type/index'])]);?>
				<?php echo Html::button('商户列表',['id'=>'btn_merchant_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/merchant/index'])]);?>
				<?php echo Html::button('商户详情',['id'=>'btn_merchant_detail','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/merchant/view'])]);?>
				
				<?php echo Html::button('商户动态列表',['id'=>'btn_merchant_blog_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/blog/vip-blog/index'])]);?>
				<?php echo Html::button('商户案例列表',['id'=>'btn_merchant_case_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/vip-case/index'])]);?>
				<?php echo Html::button('商户组团服务列表',['id'=>'btn_merchant_package_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/basic/activity/index'])]);?>
				<?php echo Html::button('商户服务评价列表',['id'=>'btn_merchant_cmt_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/product-comment/index'])]);?>
				
				<?php echo Html::button('商户案例数量',['id'=>'btn_merchant_VipCaseCount','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/merchant/vip-case-count'])]);?>
				<?php echo Html::button('商户动态数量',['id'=>'btn_merchant_VipBlogCount','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/merchant/vip-blog-count'])]);?>
				<?php echo Html::button('商户团体数量',['id'=>'btn_merchant_ActivityCount','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/merchant/activity-count'])]);?>
				<?php echo Html::button('商户服务评价数量',['id'=>'btn_merchant_ProductCommentCount','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/vip/merchant/product-comment-count'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('组团服务列表',['id'=>'btn_activity_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/basic/activity/index'])]);?>
				<?php echo Html::button('组团服务详情',['id'=>'btn_activity_detail','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/basic/activity/view'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('我的消息',['id'=>'btn_sys_notify_log_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/system/sys-notify-log/index'])]);?>
				<?php echo Html::button('查看消息',['id'=>'btn_sys_notify_log_view','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/system/sys-notify-log/view'])]);?>
				<?php echo Html::button('我的收藏商户',['id'=>'btn_vip_collect_vip_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/vip/vip-collect/index'])]);?>
				<?php echo Html::button('我的收藏案例',['id'=>'btn_vip_collect_case_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/vip/vip-collect/index'])]);?>
				<?php echo Html::button('商家用户协议',['id'=>'btn_register_agreement','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-article/view'])]);?>
				<?php echo Html::button('平台联系方式',['id'=>'btn_sys_config_service_tel','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/system/sys-config/view-service-tel'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('论坛版块',['id'=>'btn_blog_type_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/blog/vip-blog-type/index'])]);?>
				<?php echo Html::button('帖子列表',['id'=>'btn_blog_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/blog/vip-blog/index'])]);?>
				<?php echo Html::button('帖子详情',['id'=>'btn_blog_detail','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/blog/vip-blog/view'])]);?>
				<?php echo Html::button('帖子回复列表',['id'=>'btn_blog_cmt_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/blog/vip-blog-cmt/index'])]);?>
				<?php echo Html::button('帖子回复列表-作者回复',['id'=>'btn_blog_cmt_reply_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/blog/vip-blog-cmt/index'])]);?>
				<?php echo Html::button('作者发帖',['id'=>'btn_blog_create','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/blog/vip-blog/create'])]);?>
				<?php echo Html::button('作者更新发帖（传图片)',['id'=>'btn_blog_update','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/blog/vip-blog/update','id'=>'1'])]);?>
				<?php echo Html::button('用户回帖',['id'=>'btn_blog_cmt_create','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/blog/vip-blog-cmt/create'])]);?>
				<?php echo Html::button('作者回复评论',['id'=>'btn_blog_cmt_reply_create','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/blog/vip-blog-cmt/create'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('我的订单列表',['id'=>'btn_so_sheet_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet-detail/index'])]);?>
				<?php echo Html::button('订单详情',['id'=>'btn_so_sheet_detail','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet/view'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('订单咨询列表',['id'=>'btn_quotation_list','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/quotation/index'])]);?>
				<?php echo Html::button('订单咨询详情',['id'=>'btn_quotation_view','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/quotation/view'])]);?>
				<?php echo Html::button('订单咨询确认',['id'=>'btn_quotation_create','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/quotation/create'])]);?>
				<?php echo Html::button('订单咨询确认-提交',['id'=>'btn_quotation_create_submit','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/quotation/create'])]);?>
				
			</div>
			
			<div class="form-group">
				<?php echo Html::button('订单确认-个人服务',['id'=>'btn_product_buy','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet/create'])]);?>
				<?php echo Html::button('订单提交-个人服务',['id'=>'btn_order_product_submit','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet/create'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('订单确认-团体服务',['id'=>'btn_package_buy','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet/create-package'])]);?>
				<?php echo Html::button('订单提交-团体服务',['id'=>'btn_order_package_submit','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet/create-package'])]);?>
			</div>
			
			<div class="form-group">
				<?php echo Html::button('订单确认-订单咨询',['id'=>'btn_quotation_buy','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet/create-quotation'])]);?>
				<?php echo Html::button('订单提交-订单咨询',['id'=>'btn_order_quotation_submit','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet/create-quotation'])]);?>
			</div>
			
			
			<div class="form-group">
				<?php echo Html::button('订单取消',['id'=>'btn_order_cancel','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet/cancel'])]);?>
				<?php echo Html::button('订单支付确认',['id'=>'btn_order_pay','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet/pay'])]);?>
				<?php echo Html::button('订单支付成功回调',['id'=>'btn_order_pay_callback','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet/pay-callback'])]);?>
				<?php echo Html::button('确认交易完成',['id'=>'btn_order_done','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet/done'])]);?>
				<?php echo Html::button('订单评价',['id'=>'btn_product_comment_create','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/vip/product-comment/create'])]);?>
				<?php echo Html::button('退款申请',['id'=>'btn_refund_apply_create','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/refund-apply/create'])]);?>
				<?php echo Html::button('订单权限',['id'=>'btn_order_auth','class' => 'btn btn-primary','url'=>Url::to(['/vip/api/member/order/so-sheet/auth'])]);?>
			</div>
			
		</div>
			
			
    	</div>
    	

</div>

<?php 
$this->registerJsFile("js/admin/apiTest.js",['depends' => [\yii\web\JqueryAsset::className()]])
?>
