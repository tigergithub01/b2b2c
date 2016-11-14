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
			'Vip[sms_code]' : 'wl1234', //手机验证码
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
			'Vip[vip_name]' : 'tiger', //昵称
			}
		);		
	});
	
	//获取会员信息
	//http://localhost:8089/vip/api/member/vip/vip/view
	$("#btn_vip_info").click(function() {
		test_api($(this).attr('url'),
			{
			}
		);		
	});
	
	
	//更新会员信息
	//http://localhost:8089/vip/api/member/vip/vip/update
	$("#btn_vip_update").click(function() {
		test_api($(this).attr('url'),
			{
			'Vip[vip_name]' : '昵称-修改', //昵称
			'Vip[sex]' : '23001', //性别：{23001：男，23002：女}
			'Vip[wedding_date]' : '2016-12-12', //婚期
			'Vip[birthday]' : '2010-12-12', //生日
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
	
	
	/*
	 	案例列表
		http://localhost:8089/vip/api/vip/vip-case/index?page=2&per-page=3&sort=name&VipCaseSearch[name]=test
	*/
	$("#btn_vip_case_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'2',//页码
				'per-page' : '3', //每页行数
				'sort' : 'name', //排序（降序为sort=-name)
				'VipCaseSearch[name]' : 'test', //参数（案例名称)
				}
			);
	});
	
	/*
	 	案例详情
		http://localhost:8089/vip/api/vip/vip-case/view?id=1
	*/
	$("#btn_vip_case_detail").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'1',//案例编号
				}
			);
	});
	
	/*
	 	商户列表
		http://localhost:8089/vip/api/vip/merchant/index?page=2&per-page=3&sort=vip_id&MerchantSearch[vip_name]=1
	*/
	$("#btn_merchant_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : 'vip_name', //排序
				//'MerchantSearch[vip_id]' : '137', //手机号码
				//'MerchantSearch[vip_name]' : '1', //商户名（昵称）
				'MerchantSearch[vip_type_id]' : '1', //商户类型
				}
			);
	});
	
	/*
	 	商户详情
		http://localhost:8089/vip/api/vip/merchant/view?id=1
	*/
	$("#btn_merchant_detail").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'1',//商户编号
				}
			);
	});
	
	/*
	 	商户案例列表
		http://localhost:8089/vip/api/vip/vip-case/index?page=2&per-page=3&sort=name&VipCaseSearch[vip_id]=1
	*/
	$("#btn_merchant_case_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'2',//页码
				'per-page' : '3', //每页行数
				'sort' : 'name', //排序（降序为sort=-name)
				'VipCaseSearch[vip_id]' : 1, //商户编号
				}
			);
	});
	
	/*
	 	商户团体服务列表
	 	http://localhost:8089/vip/api/basic/activity/index
		http://localhost:8089/vip/api/basic/activity/index?page=2&per-page=3&sort=name&ActivitySearch[vip_id]=2
	*/
	$("#btn_merchant_package_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'2',//页码
				'per-page' : '3', //每页行数
				'sort' : 'name', //排序（降序为sort=-name)
				'ActivitySearch[vip_id]' : 2, //商户编号
				}
			);
	});
	
	/*
	 	商户评价列表
		http://localhost:8089/vip/api/vip/product-comment/index?page=2&per-page=3&sort=-comment_date&ProductCommentSearch[merchant_id]=1
	*/
	$("#btn_merchant_cmt_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'2',//页码
				'per-page' : '3', //每页行数
				'sort' : '-comment_date', //排序（降序为sort=-comment_date)
				'ProductCommentSearch[merchant_id]' : 1, //商户编号
				}
			);
	});
	
	
	/*
	 	组团服务列表
		http://localhost:8089/vip/api/basic/activity/index?page=2&per-page=3&sort=name
	*/
	$("#btn_activity_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'2',//页码
				'per-page' : '3', //每页行数
				'sort' : 'name', //排序（降序为sort=-name)
				//'VipCaseSearch[vip_id]' : 1, //商户编号
				}
			);
	});
	
	/*
 	组团服务明细
		http://localhost:8089/vip/api/basic/activity/view?id=1
	*/
	$("#btn_activity_detail").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'1',//团体服务编号
				}
			);
	});
	
	
	/*
	 	我的消息
		http://localhost:8089/vip/api/member/system/sys-notify-log/index?page=1&per-page=3&sort=-create_date
	*/
	$("#btn_sys_notify_log_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'2',//页码
				'per-page' : '3', //每页行数
				'sort' : '-create_date', //排序
				}
			);
	});

	/*
	 	我的关注
		http://localhost:8089/vip/api/member/vip/vip-concern/index?page=1&per-page=3&sort=-concern_date
		http://localhost:8089/vip/api/member/vip/vip-concern/view?id=1
	*/
	$("#btn_vip_concern_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '3', //每页行数
				'sort' : '-concern_date', //排序
				}
			);
	});
	
	/*
	 	我的收藏
		http://localhost:8089/vip/api/member/vip/vip-collect/index?page=1&per-page=3&sort=-collect_date
		http://localhost:8089/vip/api/member/vip/vip-collect/view?id=1
	*/
	$("#btn_vip_collect_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '3', //每页行数
				'sort' : '-collect_date', //排序
				}
			);
	});
	
	/*
	 	订单列表
		http://localhost:8089/vip/api/member/order/so-sheet/index?page=1&per-page=3&sort=-order_date
	*/
	$("#btn_so_sheet_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '3', //每页行数
				'sort' : '-collect_date', //排序
				}
			);
	});
	
	
	/*
	 	订单详情
		http://localhost:8089/vip/api/member/order/so-sheet/view?id=1
	*/
	$("#btn_so_sheet_detail").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'1',//编号
				}
			);
	});
	
	/*
	 	订单提交-个人服务
		http://localhost:8089/vip/api/member/order/so-sheet/create
	*/
	$("#btn_order_submit").click(function() {
		test_api($(this).attr('url'),
				{
				'product_id':'1',//产品编号（个人服务)
				'SoSheet[consignee]':'随便', //婚礼人
				'SoSheet[mobile]':'13724345562', //婚礼人手机号码
				'SoSheet[service_date]':'2017-01-01', //婚礼服务时间
				'SoSheet[budget_amount]':'20000', //婚礼预算
				'SoSheet[related_services][0]':'27001', //婚礼需要人员 - 策划师
				'SoSheet[related_services][1]':'27002', //婚礼需要人员 - 主持人
				'SoSheet[related_services][2]':'27003', //婚礼需要人员 - 摄影师
				'SoSheet[service_style]':'26001', //婚礼类型（室内26001，室外26002）
				'SoSheet[message]':'我的需求......', //买家留言
				}
			);
	});
	
	/*
	 	订单提交-团体服务
		http://localhost:8089/vip/api/member/order/so-sheet/create-package
	*/
	$("#btn_order_submit_package").click(function() {
		test_api($(this).attr('url'),
				{
				'activity_id':'1',//团体服务编号
				'SoSheet[consignee]':'随便', //婚礼人
				'SoSheet[mobile]':'13724345562', //婚礼人手机号码
				'SoSheet[service_date]':'2017-01-01', //婚礼服务时间
				'SoSheet[budget_amount]':'20000', //婚礼预算
				'SoSheet[related_services][0]':'27001', //婚礼需要人员 - 策划师
				'SoSheet[related_services][1]':'27002', //婚礼需要人员 - 主持人
				'SoSheet[related_services][2]':'27003', //婚礼需要人员 - 摄影师
				'SoSheet[service_style]':'26001', //婚礼类型（室内26001，室外26002）
				'SoSheet[message]':'我的需求..团体....', //买家留言
				}
			);
	});
	
	/*
	 	订单提交-订单咨询
		http://localhost:8089/vip/api/member/order/so-sheet/create-consult
	*/
	$("#btn_order_submit_consult").click(function() {
		test_api($(this).attr('url'),
				{
				'merchant_id':'2',//商家编号
				'SoSheet[consignee]':'随便', //婚礼人
				'SoSheet[mobile]':'13724345562', //婚礼人手机号码
				'SoSheet[service_date]':'2017-01-01', //婚礼服务时间
				'SoSheet[budget_amount]':'20000', //婚礼预算
				'SoSheet[related_services][0]':'27001', //婚礼需要人员 - 策划师
				'SoSheet[related_services][1]':'27002', //婚礼需要人员 - 主持人
				'SoSheet[related_services][2]':'27003', //婚礼需要人员 - 摄影师
				'SoSheet[service_style]':'26001', //婚礼类型（室内26001，室外26002）
				'SoSheet[message]':'我的需求..团体....', //买家留言
				}
			);
	});
	
	
	
	
	
	/*
	 	论坛板块
		http://localhost:8089/vip/api/blog/vip-blog-type/index?page=1&per-page=3&sort=name
	*/
	$("#btn_blog_type_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '3', //每页行数
				'sort' : 'name', //排序
				}
			);
	});
	
	
	/*
 		帖子列表
		http://localhost:8089/vip/api/blog/vip-blog/index?page=1&per-page=3&sort=-create_date
	*/
	$("#btn_blog_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '3', //每页行数
				'sort' : '-create_date', //排序
				}
			);
	});
	
	/*
			帖子详情
		http://localhost:8089/vip/api/blog/vip-blog/view?id=1
	*/
	$("#btn_blog_detail").click(function() {
		test_api($(this).attr('url'),
				{
			'id':'1',//编号
				}
			);
	});
	
	
	/*
		论坛评论
		http://localhost:8089/vip/api/blog/vip-blog-cmt/index?page=1&per-page=3&sort=-reply_date&VipBlogCmtSearch[blog_id]=1
	*/
	$("#btn_blog_cmt_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '3', //每页行数
				'sort' : '-reply_date', //排序
				'VipBlogCmtSearch[blog_id]' : 1, //帖子编号
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
	
	//combine
	$.extend(params,{
		'app_uid' : '1',
		'app_time' : '1478671676',
		'app_key' : 'ee6c68709728da6b5be65769793716a8', 
	});
	
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





