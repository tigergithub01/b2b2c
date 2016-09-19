/*
delete from t_sys_parameter where type_id = 21;
delete from t_sys_parameter_type where id = 21;
*/

/*插入数据字典*/
/*
insert into t_sys_parameter_type(id,name,description) values(1,'是否（有效）标志位',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1,1,'是',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(0,1,'否',null,2);

insert into t_sys_parameter_type(id,name,description) values(2,'产品状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(201,2,'正常销售',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(202,2,'下架',null,2);

insert into t_sys_parameter_type(id,name,description) values(3,'审核状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(301,3,'未审核',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(302,3,'审核不通过',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(303,3,'审核通过',null,3);

insert into t_sys_parameter_type(id,name,description) values(4,'订单类型',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(401,4,'普通订单',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(402,4,'定制订单',null,2);


insert into t_sys_parameter_type(id,name,description) values(5,'订单状态-服务类普通订单',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(501,5,'待确认','定制订单需要此状态，普通订单不需要',1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(502,5,'待付款',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(503,5,'已取消','用户未付款时直接取消',3);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(504,5,'待接单',null,4);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(505,5,'待服务',null,5);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(506,5,'待退款','用户申请退款，待接单与待服务状态都可以申请退款',6);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(507,5,'已关闭','已经退款给用户，订单关闭',7);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(508,5,'交易完成','客户付尾款，商户确认服务完成',8);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(509,5,'待评价','交易完成可评价',9);


insert into t_sys_parameter_type(id,name,description) values(6,'付款状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(601,6,'未付款',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(602,6,'部分支付',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(603,6,'已付款',null,3);

insert into t_sys_parameter_type(id,name,description) values(7,'配送状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(701,7,'未发货',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(702,7,'已发货',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(703,7,'已收货',null,3);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(704,7,'备货中',null,4);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(705,7,'已发货(部分商品)',null,5);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(706,7,'发货中(处理分单)',null,6);


insert into t_sys_parameter_type(id,name,description) values(8,'发票类型',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(801,8,'电子发票',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(802,8,'纸质发票',null,2);


insert into t_sys_parameter_type(id,name,description) values(9,'退货申请单状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(901,9,'审核中',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(902,9,'退货处理中(审核通过)',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(903,9,'已退货',null,3);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(904,9,'审核不通过',null,4);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(905,9,'用户撤销',null,5);

insert into t_sys_parameter_type(id,name,description) values(10,'退货单状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1001,10,'待退货',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1002,10,'已完成',null,2);


insert into t_sys_parameter_type(id,name,description) values(11,'发货单状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1101,11,'未发货',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1102,11,'已发货',null,2);


insert into t_sys_parameter_type(id,name,description) values(12,'评价等级',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1201,12,'差评-1星',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1202,12,'中评-2星',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1203,12,'中评-3星',null,3);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1204,12,'好评-4星',null,4);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1205,12,'好评-5星',null,5);

insert into t_sys_parameter_type(id,name,description) values(13,'验证码类型',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1301,13,'手机号码验证',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1302,13,'邮箱验证',null,2);

insert into t_sys_parameter_type(id,name,description) values(14,'验证码用途',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1401,14,'注册',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1402,14,'找回密码',null,2);


insert into t_sys_parameter_type(id,name,description) values(15,'会员状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1501,15,'正常',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1502,15,'停用',null,2);

insert into t_sys_parameter_type(id,name,description) values(16,'博客分类',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1601,16,'会员博客',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1602,16,'商户博客',null,2);

insert into t_sys_parameter_type(id,name,description) values(17,'字段录入类型',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1701,17,'输入',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1702,17,'从列表选取',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1703,17,'日期选择',null,3);


insert into t_sys_parameter_type(id,name,description) values(18,'优惠券发送方式',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1801,18,'按用户发放',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1802,18,'按商品发放',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1803,18,'按订单金额发放',null,3);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1804,18,'线下发放的红包',null,4);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1805,18,'注册送红包',null,5);

insert into t_sys_parameter_type(id,name,description) values(19,'案例类别',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1901,19,'个人案例',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1902,19,'团体案例','团体案例可以通过订单来生成，也可以手动创建;团体案例展示人员为主',2);

insert into t_sys_parameter_type(id,name,description) values(20,'公告类型',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(2001,20,'店铺公告',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(2002,20,'平台公告',null,2);

insert into t_sys_parameter_type(id,name,description) values(21,'公告发送范围',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(2101,21,'全部（商户+会员）',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(2102,21,'商户',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(2103,21,'会员',null,3);



*/
/*
select * from t_sys_parameter_type;
select * from t_sys_parameter;
*/

select * from t_pay_type;

/**插入支付方式**/
insert into t_pay_type(code,name,status,is_cod)values('wxpay','微信支付',1,0);
insert into t_pay_type(code,name,status,is_cod)values('alipay','支付宝',1,0);
