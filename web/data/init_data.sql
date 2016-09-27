/*
delete from t_sys_parameter where type_id = 21;
delete from t_sys_parameter_type where id = 21;
*/

/*插入数据字典*/

insert into t_sys_parameter_type(id,name,description) values(1,'是否（有效）标志位',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(1,1,'是',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(0,1,'否',null,2);

insert into t_sys_parameter_type(id,name,description) values(2,'产品状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(2001,2,'正常销售',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(2002,2,'下架',null,2);

insert into t_sys_parameter_type(id,name,description) values(3,'审核状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(3001,3,'未审核',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(3002,3,'审核不通过',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(3003,3,'审核通过',null,3);

insert into t_sys_parameter_type(id,name,description) values(4,'订单类型',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(4001,4,'普通订单',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(4002,4,'定制订单',null,2);


insert into t_sys_parameter_type(id,name,description) values(5,'订单状态-服务类普通订单',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(5001,5,'待确认','定制订单需要此状态，普通订单不需要',1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(5002,5,'待付款',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(5003,5,'已取消','用户未付款时直接取消',3);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(5004,5,'待接单',null,4);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(5005,5,'待服务',null,5);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(5006,5,'待退款','用户申请退款，待接单与待服务状态都可以申请退款',6);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(5007,5,'已关闭','已经退款给用户，订单关闭',7);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(5008,5,'交易完成','客户付尾款，商户确认服务完成',8);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(5009,5,'待评价','交易完成可评价',9);


insert into t_sys_parameter_type(id,name,description) values(6,'付款状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(6001,6,'未付款',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(6002,6,'部分支付',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(6003,6,'已付款',null,3);

insert into t_sys_parameter_type(id,name,description) values(7,'配送状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(7001,7,'未发货',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(7002,7,'已发货',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(7003,7,'已收货',null,3);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(7004,7,'备货中',null,4);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(7005,7,'已发货(部分商品)',null,5);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(7006,7,'发货中(处理分单)',null,6);


insert into t_sys_parameter_type(id,name,description) values(8,'发票类型',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(8001,8,'电子发票',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(8002,8,'纸质发票',null,2);


insert into t_sys_parameter_type(id,name,description) values(9,'退货申请单状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(9001,9,'审核中',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(9002,9,'退货处理中(审核通过)',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(9003,9,'已退货',null,3);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(9004,9,'审核不通过',null,4);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(9005,9,'用户撤销',null,5);

insert into t_sys_parameter_type(id,name,description) values(10,'退货单状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(10001,10,'待退货',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(10002,10,'已完成',null,2);


insert into t_sys_parameter_type(id,name,description) values(11,'发货单状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(11001,11,'未发货',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(11002,11,'已发货',null,2);


insert into t_sys_parameter_type(id,name,description) values(12,'评价等级',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(12001,12,'差评-1星',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(12002,12,'中评-2星',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(12003,12,'中评-3星',null,3);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(12004,12,'好评-4星',null,4);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(12005,12,'好评-5星',null,5);

insert into t_sys_parameter_type(id,name,description) values(13,'验证码类型',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(13001,13,'手机号码验证',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(13002,13,'邮箱验证',null,2);

insert into t_sys_parameter_type(id,name,description) values(14,'验证码用途',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(14001,14,'注册',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(14002,14,'找回密码',null,2);


insert into t_sys_parameter_type(id,name,description) values(15,'会员状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(15001,15,'正常',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(15002,15,'停用',null,2);

insert into t_sys_parameter_type(id,name,description) values(16,'博客分类',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(16001,16,'会员博客',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(16002,16,'商户博客',null,2);

insert into t_sys_parameter_type(id,name,description) values(17,'字段录入类型',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(17001,17,'输入',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(17002,17,'从列表选取',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(17003,17,'日期选择',null,3);


insert into t_sys_parameter_type(id,name,description) values(18,'优惠券发送方式',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(18001,18,'按用户发放',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(18002,18,'按商品发放',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(18003,18,'按订单金额发放',null,3);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(18004,18,'线下发放的红包',null,4);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(18005,18,'注册送红包',null,5);

insert into t_sys_parameter_type(id,name,description) values(19,'案例类别',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(19001,19,'个人案例',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(19002,19,'团体案例','团体案例可以通过订单来生成，也可以手动创建;团体案例展示人员为主',2);

insert into t_sys_parameter_type(id,name,description) values(20,'公告类型',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(20001,20,'店铺公告',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(20002,20,'平台公告',null,2);

insert into t_sys_parameter_type(id,name,description) values(21,'公告发送范围',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(21002,21,'商户',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(21003,21,'会员',null,3);


insert into t_sys_parameter_type(id,name,description) values(22,'区域类型',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(22001,22,'国家',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(22002,22,'省份（直辖市）',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(22003,22,'市',null,3);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(22004,22,'区',null,4);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(22005,22,'县（街道)',null,5);



/*
select * from t_sys_parameter_type;
select * from t_sys_parameter;
*/

/*

insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(2101,21,'全部（商户+会员）',null,1);
*/

/**
insert into t_sys_parameter_type(id,name,description) values(23,'婚礼人类型',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(23001,23,'策划师',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(23002,23,'主持人',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(23003,23,'摄影师',null,3);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(23004,23,'化妆师',null,4);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(23005,23,'摄像师)',null,5);



*/

/*
select * from t_pay_type;
*/
/**插入支付方式**/
insert into t_pay_type(code,name,status,is_cod)values('wxpay','微信支付',1,0);
insert into t_pay_type(code,name,status,is_cod)values('alipay','支付宝',1,0);

/*
select * from t_sys_app_info;
select * from t_sys_app_release;

婚礼兔andorid版

update t_sys_app_release set name = 'v1.0' where

*/
/**插入app信息*/
insert into t_sys_app_info(name,code,description,release_id) values('婚礼兔andorid版','wedding_android',null,null);
insert into t_sys_app_release(name,ver_no,upgrade_desc,force_upgrade,app_path,app_info_id)values('v1.0',1,'初始版本',1,'app/wedding.apk',1);
update t_sys_app_info set release_id =1 where code = 'wedding_android';


/**插入会员（商户）类型*/
insert into t_vip_type(name,seq_id,merchant_flag)values('策划师',1,1);
insert into t_vip_type(name,seq_id,merchant_flag)values('主持人',2,1);
insert into t_vip_type(name,seq_id,merchant_flag)values('摄影师',3,1);
insert into t_vip_type(name,seq_id,merchant_flag)values('化妆师',4,1);
insert into t_vip_type(name,seq_id,merchant_flag)values('摄像师',5,1);

/**插入产品分类信息*/
/*
select * from t_product_type;
*/
insert into t_product_type(name,parent_id,description,seq_id)values('婚礼服务',null,null,1);
insert into t_product_type(name,parent_id,description,seq_id)values('策划师',1,null,1);
insert into t_product_type(name,parent_id,description,seq_id)values('主持人',1,null,2);
insert into t_product_type(name,parent_id,description,seq_id)values('摄影师',1,null,3);
insert into t_product_type(name,parent_id,description,seq_id)values('化妆师',1,null,4);
insert into t_product_type(name,parent_id,description,seq_id)values('摄像师',1,null,5);

insert into t_product_type(name,parent_id,description,seq_id)values('结婚用品',null,null,2);

/**插入案例分类信息*/
/**
select * from t_vip_case_type;
*/
insert into t_vip_case_type(name,vip_type_id)values('策划师',1);
insert into t_vip_case_type(name,vip_type_id)values('主持人',2);
insert into t_vip_case_type(name,vip_type_id)values('摄影师',3);
insert into t_vip_case_type(name,vip_type_id)values('化妆师',4);
insert into t_vip_case_type(name,vip_type_id)values('摄像师',5);









