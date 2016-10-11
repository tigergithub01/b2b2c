/**
 * api 测试
 * 
 * 
返回结果说明：
{
"err_code":null,//错误代码，需要登录时返回-1001
"status":false, //请求状态：请求正常返回true, 请求出错返回false
"value":null, //返回值：请求正常时返回值
"message":"短信验证码不正确。", //返回消息
"attributeErrors":{"sms_code":"短信验证码不正确。"} //请求验证错误消息
}
 */

$(function() {
	//商家注册协议
	//http://localhost:8089/vip/api/system/sys-article/view
	$("#btn_register_agreement").click(function() {
		test_api($(this).attr('url'),null);		
	});
	
	//
	/**
	 	区域信息：
	 	http://localhost:8089/vip/api/system/sys-region/index
	 	
	 	insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(22001,22,'国家',null,1);
		insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(22002,22,'省份（直辖市）',null,2);
		insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(22003,22,'市',null,3);
		insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(22004,22,'区',null,4);
		insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(22005,22,'县（街道)',null,5);
	 */
	$("#btn_sys_region").click(function() {
		test_api($(this).attr('url'),
			{
			region_type:'22003',//电话号码，
			parent_id : 48543, //不需要图形验证码
			}
		);		
	});
	
	/**
	 * 地区信息（根据商家获取）：
	 * http://localhost:8089/vip/api/system/sys-region/merchant-regions
	 */
	$("#btn_sys_region_merchant").click(function() {
		test_api($(this).attr('url'),
			{
			}
		);		
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
	
	//验证短信验证码
	//http://localhost:8089/vip/member/system/sms/verify-sms-code
	$("#btn_verify_sms_code").click(function() {
		test_api($(this).attr('url'),
			{
			vip_id:'13724346625',//电话号码
			sms_code : '747580', //不需要图形验证码
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
	
	/*
	 	android客户端下载
		http://localhost:8089/vip/api/system/sys-app-info/index?code=wedding_android
	*/
	$("#btn_andorid_download").click(function() {
		window.location.href = $(this).attr('url');
	});
	
	/*
	 	ANDROID 最新版本检测
		http://localhost:8089/vip/api/system/sys-app-release/index?code=wedding_android
	*/
	$("#btn_andorid_app_release").click(function() {
		test_api($(this).attr('url'),
				{
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
	$("#txt_api_return").val('');
	$.ajax({     
	    url: req_url,     
	    type:'post',  
	    dataType:'json', 
	    data: params,     
	    async: true, 
	    error:function(err){
	    	if(err!=null && err.responseJSON!=null){
	    		alert('获取数据失败！'+err.responseJSON.message);
	    		$("#txt_api_return").val(err.responseJSON.message);
	    	}
	    },   
	    success:function(data){ 
	    	console.debug(data);
	    	$("#txt_api_return").val(JSON.stringify(data));
		    if(data.status){
		    	alert('成功！'+data.message);		    	
		    }else{
		    	alert(data.message);
		    }
	    }  
	}); 
}





