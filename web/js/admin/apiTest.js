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
	/**
	 	商家注册协议
	 	http://localhost:8089/vip/api/system/sys-article/view
	 */
	$("#btn_register_agreement").click(function() {
		test_api($(this).attr('url'),
			{
			
			},
			'get'
		);		
	});
	
	/**
	 	平台联系电话：
	 	http://localhost:8089/vip/api/system/sys-config/view-service-tel
	 */
	$("#btn_sys_config_service_tel").click(function() {
		test_api($(this).attr('url'),
				{
				
				},
				'get'
			);
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
			region_type:'22003',//区域类型
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
	
	/*
	 	案例列表
		http://localhost:8089/vip/api/vip/vip-case/index
	*/
	$("#btn_home_vip_case_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : 'name', //排序（降序为sort=-name)
				'VipCaseSearch[is_hot]' : '1', //是否经典案例？1：是；0：否
				},
				'get'
			);
	});

	
	//获取验证码
	//http://localhost:8089/vip/member/system/sms/index
	$("#btn_get_sms_code").click(function() {
		test_api($(this).attr('url'),
			{
			vip_id:'13724346621',//电话号码
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
		http://localhost:8089/vip/api/vip/vip-case/index
	*/
	$("#btn_vip_case_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : 'name', //排序（降序为sort=-name)
				//'VipCaseSearch[name]' : 'test', //参数（案例名称)
				},
				'get'
			);
	});
	
	/*
	 	案例详情
		http://localhost:8089/vip/api/vip/vip-case/view
	*/
	$("#btn_vip_case_detail").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'1',//案例编号
				},
				'get'
			);
	});
	
	/*
	 	收藏
		http://localhost:8089/vip/api/member/vip/vip-collect/create
		
		const collect_case = 28001; //案例
		const collect_vip = 28002; //商家
		const collect_prod = 28003; //产品
		const collect_act = 28004; //团体服务
		const collect_blog = 28005; //话题
	*/
	$("#btn_vip_collect_create").click(function() {
		test_api($(this).attr('url'),
				{
				'ref_id':'1',//案例编号
				'VipCollect[collect_type]':'28001',//收藏类型(案例)
				//'VipCollect[collect_type]':'28002',//收藏类型(商家)
				},
				'post'
			);
	});
	
	/*
	 	取消收藏
		http://localhost:8089/vip/api/member/vip/vip-collect/delete
	*/
	$("#btn_vip_collect_delete").click(function() {
		test_api($(this).attr('url'),
				{
				'ref_id':'1',//关联编号
				'collect_type':'28001',//收藏类型
				},
				'post'
			);
	});
	
	/*
	 	收藏数量统计
		http://localhost:8089/vip/api/member/vip/vip-collect/count
	*/
	$("#btn_vip_collect_count").click(function() {
		test_api($(this).attr('url'),
				{
				'ref_id':'1',//关联编号
				'collect_type':'28001',//收藏类型
				},
				'get'
			);
	});
	
	/*
	 	商户分类
		http://localhost:8089/vip/api/vip/vip-type/index
	*/
	$("#btn_merchant_type_list").click(function() {
		test_api($(this).attr('url'),
				{
					'VipTypeSearch[merchant_flag]' : '1', //会员类别（0：会员；1：商户）
				},
				'get'
			);
	});
	/*
	 	商户列表
		http://localhost:8089/vip/api/vip/merchant/index
		
		商家类型：
		1	策划师
		2	主持人
		3	摄影师
		4	化妆师
		5	摄像师
	    
	*/
	$("#btn_merchant_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : 'vip_name', //排序
				'MerchantSearch[vip_type_id]' : '1', //商家类型
				'MerchantSearch[vip_name]' : '', //商户名（昵称）
				},
				'get'
			);
	});
	
	/*
	 	商户详情
		http://localhost:8089/vip/api/vip/merchant/view?id=1
	*/
	$("#btn_merchant_detail").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'2',//商户编号
				},
				'get'
			);
	});
	
	/*
	 	商户案例列表
		http://localhost:8089/vip/api/vip/vip-case/index
	*/
	$("#btn_merchant_case_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : '-create_date', //排序（降序为sort=-name)(sort=-create_date)
				'VipCaseSearch[vip_id]' : 2, //商户编号
				},
				'get'
			);
	});
	
	/*
	 	商户团体服务列表
	 	http://localhost:8089/vip/api/basic/activity/index
	*/
	$("#btn_merchant_package_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : 'name', //排序（降序为sort=-name)
				'ActivitySearch[vip_id]' : 2, //商户编号
				},
				'get'
			);
	});
	
	/*
	 	商户评价列表
		http://localhost:8089/vip/api/vip/product-comment/index
	*/
	$("#btn_merchant_cmt_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : '-comment_date', //排序（降序为sort=-comment_date)
				'ProductCommentSearch[merchant_id]' : 2, //商户编号
				},
				'get'
			);
	});
	
	/*
	 	商户案例数量
		http://localhost:8089/vip/api/vip/merchant/vip-case-count
	*/
	$("#btn_merchant_VipCaseCount").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'1',//商户编号
				},
				'get'
			);
	});
	
	/*
	 	商户动态数量
		http://localhost:8089/vip/api/vip/merchant/vip-blog-count
	*/
	$("#btn_merchant_VipBlogCount").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'1',//商户编号
				},
				'get'
			);
	});
	
	/*
	 	商户团体数量
		http://localhost:8089/vip/api/vip/merchant/activity-count
	*/
	$("#btn_merchant_ActivityCount").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'1',//商户编号
				},
				'get'
			);
	});
	
	
	/*
	 	商户服务评价数量
		http://localhost:8089/vip/api/vip/merchant/product-comment-count
	*/
	$("#btn_merchant_ProductCommentCount").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'1',//商户编号
				},
				'get'
			);
	});
	
	/*
		商户动态
		http://localhost:8089/vip/api/blog/vip-blog/index
	*/
	$("#btn_merchant_blog_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : '-create_date', //排序
				'VipBlogSearch[vip_id]':2, //商户编号
				'VipBlogSearch[blog_flag]' : '16002', //商户博客标志
				},
				'get'
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
				},
				'get'
			);
	});
	
	
	/*
	 	我的消息
		http://localhost:8089/vip/api/member/system/sys-notify-log/index
	*/
	$("#btn_sys_notify_log_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : '-create_date', //排序
				},
				'get'
			);
	});
	
	
	/*
	 	查看消息
		http://localhost:8089/vip/api/member/system/sys-notify-log/view
	*/
	$("#btn_sys_notify_log_view").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'29',//消息编号
				},
				'get'
			);
	});
	

	/*
	 	我的收藏商户
		http://localhost:8089/vip/api/member/vip/vip-collect/index
		http://localhost:8089/vip/api/member/vip/vip-collect/view
	*/
	$("#btn_vip_collect_vip_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : '-collect_date', //排序
				'VipCollectSearch[collect_type]' : '28002', //收藏商户标识
				},
				'get'
			);
	});
	
	/*
	 	我的收藏案例
		http://localhost:8089/vip/api/member/vip/vip-collect/index
	*/
	$("#btn_vip_collect_case_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : '-collect_date', //排序
				'VipCollectSearch[collect_type]' : '28001', //收藏案例标识
				},
				'get'
			);
	});
	
	/*
	 	订单列表
		http://localhost:8089/vip/api/member/order/so-sheet-detail/index
	*/
	$("#btn_so_sheet_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : '-order_date', //排序
				'SoSheetSearch[code]' : 'so2', //可选项（客户根据订单编号来进行查询)
				},
				'get'
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
				},
				'get'
			);
	});
	
	
	
	/*
	 	订单咨询列表
		http://localhost:8089/vip/api/member/order/quotation/index
	*/
	$("#btn_quotation_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : '-create_date', //排序(按照创建日期倒序）
				},
				'get'
			);
	});
	
	/*
	 	订单咨询详情
		http://localhost:8089/vip/api/member/order/quotation/index
	*/
	$("#btn_quotation_view").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'1',//咨询编号
				},
				'get'
			);
	});
	
	/*
	 	订单咨询
		http://localhost:8089/vip/api/member/order/quotation/create
	*/
	$("#btn_quotation_create").click(function() {
		test_api($(this).attr('url'),
				{
				'Quotation[merchant_id]':'2',//商家编号
				},
				'get'
			);
	});
	
	/*
	 	订单咨询  - 提交
		http://localhost:8089/vip/api/member/order/quotation/create
	*/
	$("#btn_quotation_create_submit").click(function() {
		test_api($(this).attr('url'),
				{
				'Quotation[merchant_id]':'2',//商家编号
				'Quotation[consignee]':'我是马侬', //婚礼人
				'Quotation[mobile]':'13724345562', //婚礼人手机号码
				'Quotation[service_date]':'2017-01-01', //婚礼服务时间
				'Quotation[budget_amount]':'20000', //婚礼预算
				'Quotation[related_services][0]':'27001', //婚礼需要人员 - 策划师
				'Quotation[related_services][1]':'27002', //婚礼需要人员 - 主持人
				'Quotation[related_services][2]':'27003', //婚礼需要人员 - 摄影师
				'Quotation[service_style]':'26001', //婚礼类型（室内26001，室外26002）
				'Quotation[memo]':'我的需求.......团体....', //买家留言
				},
				'post'
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
				},
				'post'
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
				},
				'post'
			);
	});
	
	
	
	/*
	 	论坛板块
		http://localhost:8089/vip/api/blog/vip-blog-type/index
	*/
	$("#btn_blog_type_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : 'name', //排序
				},
				'get'
			);
	});
	
	
	/*
 		帖子列表
		http://localhost:8089/vip/api/blog/vip-blog/index
		
		获取帖子里面的图片请调用 http://localhost:8089/vip/api/blog/vip-blog/view?id=$id
	*/
	$("#btn_blog_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : '-create_date', //排序
				'VipBlogSearch[blog_type]' : '1', //论坛板块
				'VipBlogSearch[blog_flag]' : '16001', //会员论坛
				},
				'get'
			);
	});
	
	/*
			帖子详情
		http://localhost:8089/vip/api/blog/vip-blog/view
	*/
	$("#btn_blog_detail").click(function() {
		test_api($(this).attr('url'),
				{
				'id':'6',  //编号
				},
				'get'
			);
	});
	
	
	/*
		论坛评论列表
		http://localhost:8089/vip/api/blog/vip-blog-cmt/index
	*/
	$("#btn_blog_cmt_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : '-reply_date', //排序
				'VipBlogCmtSearch[blog_id]' : 6, //帖子编号
				'VipBlogCmtSearch[blog_reply_flag]' : 1, //评论回复标识，没有此标识将查询出所有的回复，包括作者回复
				},
				'get'
			);
	});
	
	/*
		论坛评论列表 - 作者回复
		http://localhost:8089/vip/api/blog/vip-blog-cmt/index
	*/
	$("#btn_blog_cmt_reply_list").click(function() {
		test_api($(this).attr('url'),
				{
				'page':'1',//页码
				'per-page' : '10', //每页行数
				'sort' : '-reply_date', //排序
				'VipBlogCmtSearch[blog_id]' : 6, //帖子编号
				'VipBlogCmtSearch[parent_id]' : 3, //评论编号
				},
				'get'
			);
	});
	
	
	/*
		发帖
		http://localhost:8089/vip/api/member/blog/vip-blog/create
	*/
	$("#btn_blog_create").click(function() {
		test_api($(this).attr('url'),
				{
				'VipBlog[blog_type]' : '1', //帖子板块
				'VipBlog[blog_flag]' : '16001', //标志是会员博客
				'VipBlog[name]' : '发帖test', //标题
				'VipBlog[content]' : '内容内容，内容内容，内容内容', //帖子内容
				//'VipBlog[imageFiles][]' : '' //图片（多个）
				},
				'post'
			);
	});
	
	
	/*
		用户回帖
		http://localhost:8089/vip/api/member/blog/vip-blog-cmt/create
	*/
	$("#btn_blog_cmt_create").click(function() {
		test_api($(this).attr('url'),
				{
				'VipBlogCmt[blog_id]' : 6, //帖子编号
				'VipBlogCmt[content]' : '用户回复内容内容，内容内容，内容内容', //回复内容
				},
				'post'
			);
	});
	
	
	/*
		作者回复评论
		http://localhost:8089/vip/api/member/blog/vip-blog-cmt/create
	*/
	$("#btn_blog_cmt_reply_create").click(function() {
		test_api($(this).attr('url'),
				{
				'VipBlogCmt[blog_id]' : 6, //帖子编号
				'VipBlogCmt[content]' : '作者回复评论---内容内容，内容内容，内容内容', //回复内容
				'VipBlogCmt[parent_id]' : 3, //用户评论编号
				},
				'post'
			);
	});
	
	

});


/**
 * 测试
 * @param req_url
 * @param params
 */
function test_api(req_url,params,req_type){
	$("#txt_api_return").val('');
	
	if(req_type==null){
		req_type='post';
	}
	
	//combine
	$.extend(params,{
		'app_uid' : '1',
		'app_time' : '1478671676',
		'app_key' : 'ee6c68709728da6b5be65769793716a8', 
	});
	
	$.ajax({     
	    url: req_url,     
	    type: req_type,  
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





