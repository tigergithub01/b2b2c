/**
 * api 测试
 */

$(function() {
	//商家注册协议
	//http://localhost:8089/vip/api/system/sys-article/view
	$("#btn_register_agreement").click(function() {
		test_api($(this).attr('url'),null);		
	});
	
	//广告图
	//http://localhost:8089/vip/api/system/sys-ad-info/index
	$("#btn_sys_ad_info").click(function() {
		test_api($(this).attr('url'),null);		
	});
	
	//获取验证码
	//http://localhost:8089/vip/member/system/sms/index
	$("#btn_get_sms_code").click(function() {
		test_api($(this).attr('url'),
			{
			vip_id:'13724346625',//电话号码
			img_verify :0, //不需要图形验证码
			}
		);		
	});
	
	//登录
	//http://localhost:8089/vip/api/member/system/login/index
	$("#btn_vip_login").click(function() {
		test_api($(this).attr('url'),
			{
			'Vip[vip_id]':'13724346621',//登录名
			'Vip[password]' : '111111', //密码
			}
		);		
	});
	
	//登录后修改密码
	//http://localhost:8089/vip/api/member/system/modify-pwd/index
	$("#btn_vip_modify_pwd").click(function() {
		test_api($(this).attr('url'),
			{
			'Vip[password]':'111111',//原始密码
			'Vip[new_pwd]' : '111111', //新密码
			'Vip[confirm_pwd]' : '111111', //确认新密码
			'PHPSESSID': 'etv3lt04chbqmh4rid66f0bd80',//session编号
			}
		);		
	});
	
	//注销登陆
	//http://localhost:8089/vip/api/member/system/login-out/index
	$("#btn_vip_login_out").click(function() {
		test_api($(this).attr('url'),{'PHPSESSID': 'etv3lt04chbqmh4rid66f0bd80'});		
	});
	
	//找回密码
	//http://localhost:8089/vip/api/member/system/login/forgot-pwd
	$("#btn_vip_forgot_pwd").click(function() {
		test_api($(this).attr('url'),
			{
			'Vip[vip_id]':'13724346621',//原始密码
			'Vip[password]' : '111111', //新密码
			'Vip[confirm_pwd]' : '111111', //确认新密码
			'Vip[sms_code]' : '915393', //手机验证码
			}
		);		
	});
	
	//会员注册
	//http://localhost:8089/vip/api/member/system/register/index
	$("#btn_vip_register").click(function() {
		test_api($(this).attr('url'),
			{
			'Vip[vip_id]':'13724346626',//会员手机号码
			'Vip[password]' : '111111', //密码
			'Vip[confirm_pwd]' : '111111', //确认密码
			'Vip[sms_code]' : '019705', //手机验证码（完成注册吗）
			'Vip[nick_name]' : 'tiger', //昵称
			}
		);		
	});
	
	
	
	
	
	
	

});


/**
 * 测试
 * @param req_url
 * @param params
 */
function test_api(req_url,params){
	$.ajax({     
	    url: req_url,     
	    type:'post',  
	    dataType:'json', 
	    data: params,     
	    async: true, 
	    error:function(err){
	    	console.debug('获取数据失败！'+err.responseJSON.message);
	    },   
	    success:function(data){ 
	    	console.debug(data);
		    if(data.status){
		    	alert('成功！'+data.message);		    	
		    }else{
		    	alert(data.message);
		    }
	    }  
	}); 
}





