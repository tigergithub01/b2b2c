/*insert into t_pay_type(code,name,status,is_cod)values('wxpay','微信支付',1，0);
insert into t_pay_type(code,name,status,is_cod)values('alipay','支付宝',1，0);

select * from t_sys_parameter;

select * from t_sys_verify_code order by sent_time desc;

delete from t_sys_verify_code;

select * from t_vip;

select * from t_sys_user;

SELECT 53 * 4 FROM DUAL;

select * from t_vip_operation_log;

select * from t_sys_app_info;
select * from t_sys_app_release;

update t_sys_app_info set release_id = 1 where id =1;

select * from t_vip;

select * from t_vip_organization;

select * from t_activity;

select * from t_vip_extend;

select * from t_sys_region;

CREATE TABLE `t_sys_region` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键编号',
  `name` varchar(60) NOT NULL COMMENT '省份名称',
  `parent_id` bigint(20) DEFAULT NULL COMMENT '上级区域编号',
  `region_type` bigint(20) NOT NULL COMMENT '国家省市区类别',
  PRIMARY KEY (`id`),
  KEY `fk_region_parent_ref_region` (`parent_id`),
  CONSTRAINT `fk_region_parent_ref_region` FOREIGN KEY (`parent_id`) REFERENCES `t_sys_region` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4232 DEFAULT CHARSET=utf8 COMMENT='区域信息';

alter table t_sys_region drop FOREIGN KEY fk_region_parent_ref_region;

select * from t_sys_region where name = '荆州市';
select * from t_sys_region where parent_id = '48566';
select * from t_sys_region where parent_id = '48750';

alter table t_vip_org_gallery drop foreign key fk_org_gallery_ref_org foreign key (organization_id)
      references t_vip_organization (id);

drop table t_vip_org_gallery;

drop table t_sys_ad_info;

create table t_vip_org_gallery
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   organization_id      bigint(20) not null comment '关联店铺编号',
   img_url              varchar(255) not null comment '图片（放大后查看）',
   thumb_url            varchar(255) not null comment '缩略图',
   img_original         varchar(255) not null comment '原图',
   sequence_id          bigint(20) not null comment '显示顺序',
   redirect_url         varchar(100) comment '点击后跳转关联URL',
   primary key (id)
);

alter table t_vip_org_gallery comment '店铺相册(暂时作为封面）';

alter table t_vip_org_gallery add constraint fk_org_gallery_ref_org foreign key (organization_id)
      references t_vip_organization (id);

alter table t_sys_ad_info comment 'APP首页主广告栏';


alter table t_vip_org_gallery add constraint fk_org_gallery_ref_org foreign key (organization_id)
      references t_vip_organization (id);

select * from t_sys_ad_info;

delete from t_sys_ad_info;

drop table t_sys_ad_info;

create table t_sys_ad_info
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   img_url              varchar(255) not null comment '图片（放大后查看）',
   thumb_url            varchar(255) not null comment '缩略图',
   img_original         varchar(255) not null comment '原图',
   sequence_id          bigint(20) not null comment '显示顺序',
   redirect_url         varchar(255) comment '点击后跳转关联URL',
   description          varchar(255) comment '描述',
   width                int not null comment '宽度',
   height               int not null comment '高度',
   primary key (id)
);

select * from t_vip;

delete from t_vip where vip_id ='13724346623' 


select * from t_sys_verify_code order by sent_time desc;

select * from t_sys_config;

select * from t_sys_article;

select * from t_sys_app_info;

select * from t_sys_app_release;


alter table t_sys_region add constraint fk_region_type_ref_param foreign key (region_type)
      references t_sys_parameter (id);

alter table t_sys_region add constraint fk_region_parent_ref_region foreign key (parent_id)
      references t_sys_region (id);


alter table t_vip_organization add constraint fk_org_city_ref_region foreign key (city_id)
      references t_sys_region (id);

alter table t_vip_organization add constraint fk_org_country_ref_region foreign key (country_id)
      references t_sys_region (id);

alter table t_vip_organization add constraint fk_org_province_ref_region foreign key (province_id)
      references t_sys_region (id);

select * from t_product;

select * from t_vip;

select * from t_vip_blog_type;

select * from t_sys_notify_push_log;

select * from t_sys_notify_log;

select * from t_sys_notify;

drop table t_sys_notify_log;
drop table t_sys_notify;


drop table if exists t_sys_notify;


create table t_sys_notify
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   notify_type          bigint(20) comment '公告类型：店铺公告，平台公告',
   title                varchar(60) not null comment '标题',
   issue_date           datetime not null comment '发布日期',
   content              text comment '内容',
   organization_id      bigint(20) comment '发布机构(店铺发布公告时使用此字段）',
   issue_user_id        bigint(20) comment '发布人（发布公告时使用此字段）',
   send_extend          bigint(20) not null comment '发送范围[全部（商户+会员)-待定,商户,会员]',
   status               bigint(20) not null comment '是否有效（1：是，0：否）',
   is_sent              bigint(20) not null comment '是否已发送（1：是，0：否）',
   sent_time            datetime comment '发送时间',
   primary key (id)
);

alter table t_sys_notify comment '系统消息';

alter table t_sys_notify add constraint fk_notify_extend_ref_param foreign key (send_extend)
      references t_sys_parameter (id);

alter table t_sys_notify add constraint fk_notify_issue_usr_ref_usr foreign key (issue_user_id)
      references t_sys_user (id);

alter table t_sys_notify add constraint fk_notify_org_ref_org foreign key (organization_id)
      references t_vip_organization (id);

alter table t_sys_notify add constraint fk_notify_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_sys_notify add constraint fk_notify_type_ref_param foreign key (notify_type)
      references t_sys_parameter (id);

alter table t_sys_notify add constraint fk_sys_notify_sent_ref_param foreign key (is_sent)
      references t_sys_parameter (id);

create table t_sys_notify_log
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   notify_id            bigint(20) not null comment '关联通知编号',
   vip_id               bigint(20) not null comment '通知会员编号',
   create_date          datetime not null comment '消息创建时间',
   read_date            datetime comment '消息阅读时间',
   expiration_time      datetime comment '消息过期时间',
   primary key (id)
);

alter table t_sys_notify_log comment '消息发送日志';

alter table t_sys_notify_log add constraint fk_notify_push_his_ref_notify foreign key (notify_id)
      references t_sys_notify (id);

alter table t_sys_notify_log add constraint fk_notify_push_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip add constraint fk_vip_sex_ref_param foreign key (sex)
      references t_sys_parameter (id);

select * from t_vip_type;

select * from t_sys_article;

select now();


alter table t_vip_case add constraint fk_case_is_hot_ref_param foreign key (is_hot)
      references t_sys_parameter (id);

select * from t_vip_blog_type;

alter table t_vip_blog add constraint fk_vip_blog_audit_stat_ref_param foreign key (audit_status)
      references t_sys_parameter (id);


alter table t_vip_blog add constraint fk_vip_blog_audit_usr_ref_usr foreign key (audit_user_id)
      references t_sys_user (id);

alter table t_vip_blog add name                 varchar(200) not null comment '帖子标题'


alter table t_activity add  audit_status         bigint(20) not null comment '审核状态：未审核，审核不通过，已审核';
  alter table t_activity add audit_user_id        bigint(20) comment '审核人';
  alter table t_activity add audit_date           datetime comment '审核日期';


alter table t_activity add constraint fk_act_audit_stat_ref_param foreign key (audit_status)
      references t_sys_parameter (id);

alter table t_activity add constraint fk_act_audit_usr_ref_usr foreign key (audit_user_id)
      references t_sys_user (id);

select * from t_vip;

select * from t_vip_blog;


create table t_activity_type
(
   id                   bigint not null auto_increment comment '主键',
   name                 varchar(60) not null comment '活动类别名称',
   primary key (id)
);

alter table t_activity_type comment '促销活动类型';

alter table t_activity add constraint fk_activity_type_ref_type foreign key (activity_type)
      references t_activity_type (id);

alter table t_activity drop  FOREIGN KEY fk_act_type_ref_param

CREATE TABLE `t_so_sheet` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键编号',
  `sheet_type_id` bigint(20) NOT NULL COMMENT '订单类型（普通订单，定制订单）',
  `code` varchar(30) NOT NULL COMMENT '订单编号(so-年月日-顺序号，根据单据设置进行生成)',
  `vip_id` bigint(20) NOT NULL COMMENT '会员编号',
  `order_amt` decimal(20,6) NOT NULL COMMENT '订单待支付费用',
  `order_quantity` int(11) NOT NULL COMMENT '产品数量（所有商品数量汇总）',
  `goods_amt` decimal(20,6) NOT NULL COMMENT '商品总金额',
  `deliver_fee` decimal(20,6) NOT NULL COMMENT '运费',
  `order_date` datetime NOT NULL COMMENT '订单提交日期',
  `delivery_date` datetime DEFAULT NULL COMMENT '发货日期',
  `delivery_type` bigint(20) DEFAULT NULL COMMENT '配送方式',
  `pay_type_id` bigint(20) DEFAULT NULL COMMENT '支付方式',
  `pay_date` datetime DEFAULT NULL COMMENT '付款日期',
  `delivery_no` varchar(60) DEFAULT NULL COMMENT '快递单号',
  `pick_point_id` bigint(20) DEFAULT NULL COMMENT '自提点',
  `paid_amt` decimal(20,6) DEFAULT NULL COMMENT '已付款金额',
  `integral` bigint(20) NOT NULL COMMENT '消耗积分',
  `integral_money` decimal(20,6) NOT NULL COMMENT '积分折合金额',
  `coupon` decimal(20,6) NOT NULL COMMENT '优惠券消耗金额',
  `discount` decimal(20,6) NOT NULL COMMENT '折扣费用',
  `return_amt` decimal(20,6) DEFAULT NULL COMMENT '退款金额',
  `return_date` datetime DEFAULT NULL COMMENT '退款日期',
  `memo` varchar(400) DEFAULT NULL COMMENT '备注',
  `message` varchar(300) DEFAULT NULL COMMENT '买家留言',
  `order_status` bigint(20) NOT NULL COMMENT '订单状态（普通订单：待付款，已取消[用户未付款时直接取消]，待接单，待服务，待退款[用户申请退款，待接单与待服务状态都可以申请退款]，已关闭[已经退款给用户，订单关闭],[客户付尾款，商户确认服务完成]交易完成，待评价[交易完成可评价])   定制订单：待确定[用户提交购买申请]，待付款，已取消[用户未付款时直接取消]，待接单，待服务，待退款[用户申请退款，待接单与待服务状态都可以申请退款]，[客户付尾款，商户确认服务完成]交易完成，待评价[交易完成可评价]）',
  `delivery_status` bigint(20) DEFAULT NULL COMMENT '配送状态',
  `pay_status` bigint(20) NOT NULL COMMENT '支付状态',
  `consignee` varchar(30) NOT NULL COMMENT '收货人',
  `country_id` bigint(20) DEFAULT NULL COMMENT '国家',
  `province_id` bigint(20) DEFAULT NULL COMMENT '省份',
  `city_id` bigint(20) DEFAULT NULL COMMENT '城市',
  `district_id` bigint(20) DEFAULT NULL COMMENT '区域街道',
  `mobile` varchar(20) NOT NULL COMMENT '联系手机号码',
  `detail_address` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `invoice_type` bigint(20) DEFAULT NULL COMMENT '发票类型（电子发票，纸质发票)',
  `invoice_header` varchar(60) DEFAULT NULL COMMENT '发票抬头名称',
  `service_date` datetime DEFAULT NULL COMMENT '服务时间(婚礼)',
  `budget_amount` decimal(20,6) DEFAULT NULL COMMENT '婚礼预算',
  `related_service` varchar(60) DEFAULT NULL COMMENT '需要人员（多选）（婚礼策划师，摄影师，摄像师，化妆师，主持人）',
  `service_style` varchar(60) DEFAULT NULL COMMENT '婚礼样式（多选）（浪漫，简约）',
  `related_case_id` bigint(20) DEFAULT NULL COMMENT '关联案例编号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_so_code` (`code`),
  KEY `fk_so_city_ref_region` (`city_id`),
  KEY `fk_so_country_ref_region` (`country_id`),
  KEY `fk_so_district_ref_region` (`district_id`),
  KEY `fk_so_invoice_ref_param` (`invoice_type`),
  KEY `fk_so_order_stat_ref_param` (`order_status`),
  KEY `fk_so_pay_stat_ref_param` (`pay_status`),
  KEY `fk_so_province_ref_region` (`province_id`),
  KEY `fk_so_sheet_case_id_ref_org_case` (`related_case_id`),
  KEY `fk_so_sheet_ref_pay_type` (`pay_type_id`),
  KEY `fk_so_sheet_ref_pickup_point` (`pick_point_id`),
  KEY `fk_so_sheet_ref_st_type` (`sheet_type_id`),
  KEY `fk_so_sheet_ref_vip` (`vip_id`),
  KEY `fk_so_delivery_stat_ref_param` (`delivery_status`),
  KEY `fk_so_ref_delivery_type` (`delivery_type`),
  CONSTRAINT `fk_so_delivery_stat_ref_param` FOREIGN KEY (`delivery_status`) REFERENCES `t_sys_parameter` (`id`),
  CONSTRAINT `fk_so_ref_delivery_type` FOREIGN KEY (`delivery_type`) REFERENCES `t_delivery_type` (`id`),
  CONSTRAINT `fk_so_city_ref_region` FOREIGN KEY (`city_id`) REFERENCES `t_sys_region` (`id`),
  CONSTRAINT `fk_so_country_ref_region` FOREIGN KEY (`country_id`) REFERENCES `t_sys_region` (`id`),
  CONSTRAINT `fk_so_district_ref_region` FOREIGN KEY (`district_id`) REFERENCES `t_sys_region` (`id`),
  CONSTRAINT `fk_so_invoice_ref_param` FOREIGN KEY (`invoice_type`) REFERENCES `t_sys_parameter` (`id`),
  CONSTRAINT `fk_so_order_stat_ref_param` FOREIGN KEY (`order_status`) REFERENCES `t_sys_parameter` (`id`),
  CONSTRAINT `fk_so_pay_stat_ref_param` FOREIGN KEY (`pay_status`) REFERENCES `t_sys_parameter` (`id`),
  CONSTRAINT `fk_so_province_ref_region` FOREIGN KEY (`province_id`) REFERENCES `t_sys_region` (`id`),
  CONSTRAINT `fk_so_sheet_case_id_ref_org_case` FOREIGN KEY (`related_case_id`) REFERENCES `t_vip_case` (`id`),
  CONSTRAINT `fk_so_sheet_ref_pay_type` FOREIGN KEY (`pay_type_id`) REFERENCES `t_pay_type` (`id`),
  CONSTRAINT `fk_so_sheet_ref_pickup_point` FOREIGN KEY (`pick_point_id`) REFERENCES `t_pick_up_point` (`id`),
  CONSTRAINT `fk_so_sheet_ref_st_type` FOREIGN KEY (`sheet_type_id`) REFERENCES `t_sheet_type` (`id`),
  CONSTRAINT `fk_so_sheet_ref_vip` FOREIGN KEY (`vip_id`) REFERENCES `t_vip` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单信息表';



alter table t_out_stock_sheet drop  FOREIGN KEY  `fk_out_ref_delivery_type` FOREIGN KEY (`delivery_type`) REFERENCES `t_delivery_type` (`id`)
alter table t_out_stock_sheet add constraint fk_out_ref_delivery_type foreign key (delivery_type)
      references t_delivery_type_tpl (id);

CREATE TABLE `t_out_stock_sheet` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键编号',
  `sheet_type_id` bigint(20) NOT NULL COMMENT '单据类型',
  `code` varchar(30) NOT NULL COMMENT '发货单编号（根据规则自动生成）',
  `order_id` bigint(20) NOT NULL COMMENT '关联订单编号',
  `user_id` bigint(20) NOT NULL COMMENT '制单人',
  `vip_id` bigint(20) NOT NULL COMMENT '关联商户编号',
  `sheet_date` datetime NOT NULL COMMENT '单据生成时间',
  `status` bigint(20) NOT NULL COMMENT '发货单状态（未发货、已发货）',
  `delivery_type` bigint(20) NOT NULL COMMENT '配送方式',
  `delivery_no` varchar(60) NOT NULL COMMENT '快递单号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_out_code` (`code`),
  KEY `fk_out_ref_delivery_type` (`delivery_type`),
  KEY `fk_out_stock_ref_so` (`order_id`),
  KEY `fk_out_stock_sheet_ref_vip` (`vip_id`),
  KEY `fk_out_stock_stat_ref_param` (`status`),
  KEY `fk_out_stock_user_ref_user` (`user_id`),
  CONSTRAINT `fk_out_stock_user_ref_user` FOREIGN KEY (`user_id`) REFERENCES `t_sys_user` (`id`),
  CONSTRAINT `fk_out_ref_delivery_type` FOREIGN KEY (`delivery_type`) REFERENCES `t_delivery_type` (`id`),
  CONSTRAINT `fk_out_stock_ref_so` FOREIGN KEY (`order_id`) REFERENCES `t_so_sheet` (`id`),
  CONSTRAINT `fk_out_stock_sheet_ref_vip` FOREIGN KEY (`vip_id`) REFERENCES `t_vip` (`id`),
  CONSTRAINT `fk_out_stock_stat_ref_param` FOREIGN KEY (`status`) REFERENCES `t_sys_parameter` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发货单';



select * from t_sys_region limit 0,100;

select * from t_so_sheet;

alter table t_refund_sheet add merchant_id          bigint(20) not null comment '关联商户编号';

alter table t_refund_sheet add constraint fk_refund_st_merc_ref_vip foreign key (merchant_id)
      references t_vip (id);

alter table t_refund_sheet modify vip_id               bigint(20) not null comment '会员编号';

alter table t_refund_sheet_apply  add apply_date           datetime not null comment '申请日期',

alter table t_return_sheet add merchant_id          bigint(20) not null comment '关联商户编号';

alter table t_return_sheet add constraint fk_return_sheet_merc_ref_vip foreign key (merchant_id)
      references t_vip (id);

alter table t_out_stock_sheet modify vip_id               bigint(20) not null comment '会员编号';

alter table t_out_stock_sheet add merchant_id          bigint(20) not null comment '关联商户编号';

alter table t_out_stock_sheet add constraint fk_out_stock_sheet_merc_ref_vip foreign key (merchant_id)
      references t_vip (id);



alter table t_return_sheet modify vip_id               bigint(20) not null comment '会员编号';

alter table t_refund_sheet_apply  add code                 varchar(30) not null comment '退款申请单编号';
alter table t_return_apply  add code                 varchar(30) not null comment '退货申请单编号';

delete from t_refund_sheet_apply


alter table t_vip_case modify cover_img_url        varchar(255) comment '图片（放大后查看）(封面)';
 alter table t_vip_case modify cover_thumb_url      varchar(255) comment '缩略图(封面)';
 alter table t_vip_case  modify cover_img_original   varchar(255) comment '原图(封面)';


alter table t_vip_case_photo add sequence_id          bigint(20) comment '显示顺序',
alter table t_vip_case_photo add   description          varchar(255) comment '描述',


alter table t_vip_organization add district_id          bigint(20) comment '所属区域';
alter table t_vip_organization add    address              varchar(255) comment '联系地址';


alter table t_vip_organization add constraint fk_org_district_ref_region foreign key (district_id)
      references t_sys_region (id);

select * from t_vip_extend;

select * from t_vip_organization;

select * from t_vip_case_photo;

delete  from t_vip_extend;

delete  from t_vip_organization;

CREATE TABLE `t_act_package_product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `act_id` bigint(20) NOT NULL COMMENT '关联活动编号',
  `product_id` bigint(20) NOT NULL COMMENT '关联产品编号',
  `sale_price` decimal(20,6) NOT NULL COMMENT '原价',
  `package_price` decimal(20,6) NOT NULL COMMENT '套装价',
  `quantity` int(11) NOT NULL COMMENT '数量',
  PRIMARY KEY (`id`),
  KEY `fk_package_goods_ref_act` (`act_id`),
  KEY `fk_pkg_prod_ref_prod` (`product_id`),
  CONSTRAINT `fk_pkg_prod_ref_prod` FOREIGN KEY (`product_id`) REFERENCES `t_product` (`id`),
  CONSTRAINT `fk_package_goods_ref_act` FOREIGN KEY (`act_id`) REFERENCES `t_activity` (`id`),
  CONSTRAINT `fk_package_prod_ref_product` FOREIGN KEY (`product_id`) REFERENCES `t_product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠套装';

alter table t_act_package_product drop foreign key fk_pkg_prod_ref_prod;

alter table t_act_package_product modify sale_price           decimal(20,6) null comment '原价';


SELECT `actProd`.* FROM `t_act_package_product` `actProd` 
LEFT JOIN `t_activity` `act` ON `actProd`.`act_id` = `act`.`id` 
LEFT JOIN `t_product` `product` ON `actProd`.`product_id` = `product`.`id` 
LEFT JOIN `t_product` ON `actProd`.`product_id` = `t_product`.`id` 
LEFT JOIN `t_vip` `vip` ON `t_product`.`vip_id` = `vip`.`id` WHERE `actProd`.`act_id`='2'

SELECT `actProd`.* FROM `t_act_package_product` `actProd` 
LEFT JOIN `t_activity` `act` ON `actProd`.`act_id` = `act`.`id` 
LEFT JOIN `t_product` ON `actProd`.`product_id` = `t_product`.`id` 
LEFT JOIN `t_vip` `vip` ON `t_product`.`vip_id` = `vip`.`id` WHERE `actProd`.`act_id`='2'

alter table t_product modify service_flag         bigint(20) not  null comment '是否个人服务？1：是；0：否（每个商户只有一个个人服务）';

alter table t_product add constraint fk_prod_service_flag_ref_param foreign key (service_flag)
      references t_sys_parameter (id);

update t_product set service_flag = 1;


SELECT `p`.*, `vip`.`vip_name` FROM `t_product` `p` LEFT JOIN `t_vip` `vip` ON `p`.`vip_id` = `vip`.`id` WHERE `p`.`serivce_flag`=1


select * from t_vip;

update t_sys_parameter set param_val = '待审核' where id = '3001'

alter table t_so_sheet_detail  modify product_id           bigint(20) comment '关联产品编号';

alter table t_refund_sheet  modify merchant_id          bigint(20) comment '关联商户编号';

select * from t_sys_region;

update t_sys_parameter set param_val = '待提交' where id = '3001';
update t_sys_parameter set param_val = '待审核' where id = '3004';



create table t_so_sheet_vip
(
   id                   bigint(20) not null auto_increment comment '主键',
   order_id             bigint(20) not null comment '关联订单编号',
   vip_id               bigint(20) not null comment '关联商户编号',
   primary key (id)
);

alter table t_so_sheet_vip comment '订单与商户对应关系（便于查询）';

alter table t_so_sheet_vip add constraint fk_so_sheet_vip_ref_so_sheet foreign key (order_id)
      references t_so_sheet (id);

alter table t_so_sheet_vip add constraint fk_so_sheet_vip_ref_vip foreign key (vip_id)
      references t_vip (id);

select distinct product_id from t_so_sheet_detail;

select * from t_so_sheet_detail;

select * from t_so_sheet_vip;

SELECT DISTINCT `vip`.`id` FROM `t_so_sheet_detail` `so_detail` LEFT JOIN `t_activity` ON `so_detail`.`package_id` = `t_activity`.`id` LEFT JOIN `t_vip` `vip` ON `t_activity`.`vip_id` = `vip`.`id` WHERE `so_detail`.`order_id`=1

(SELECT DISTINCT `vip`.`id` FROM `t_so_sheet_detail` `so_detail` LEFT JOIN `t_product` ON `so_detail`.`product_id` = `t_product`.`id` LEFT JOIN `t_vip` `vip` ON `t_product`.`vip_id` = `vip`.`id` WHERE `so_detail`.`order_id`='1') 

UNION 

select count(1) from 
( SELECT *
FROM `t_so_sheet_detail` `so_detail` 
LEFT JOIN `t_activity` ON `so_detail`.`package_id` = `t_activity`.`id` 
LEFT JOIN `t_vip` `vip` ON `t_activity`.`vip_id` = `vip`.`id` 
WHERE `so_detail`.`order_id`='1' and so_detail.package_id is not null ) a

SELECT `so`.* FROM `t_so_sheet_vip` `sovip` LEFT JOIN `t_so_sheet` `so` ON `sovip`.`order_id` = `so`.`id` LEFT JOIN `t_so_sheet` ON `sovip`.`order_id` = `t_so_sheet`.`id` LEFT JOIN `t_vip` `vip` ON `t_so_sheet`.`vip_id` = `vip`.`id` LEFT JOIN `t_sys_region` `city` ON `t_so_sheet`.`city_id` = `city`.`id` LEFT JOIN `t_sys_region` `country` ON `t_so_sheet`.`country_id` = `country`.`id` LEFT JOIN `t_sys_parameter` `deliveryStatus` ON `t_so_sheet`.`delivery_status` = `deliveryStatus`.`id` LEFT JOIN `t_sys_region` `district` ON `t_so_sheet`.`district_id` = `district`.`id` LEFT JOIN `t_sys_parameter` `invoiceType` ON `t_so_sheet`.`invoice_type` = `invoiceType`.`id` LEFT JOIN `t_sys_parameter` `orderStatus` ON `t_so_sheet`.`order_status` = `orderStatus`.`id` LEFT JOIN `t_sys_parameter` `payStatus` ON `t_so_sheet`.`pay_status` = `payStatus`.`id` LEFT JOIN `t_sys_region` `province` ON `t_so_sheet`.`province_id` = `province`.`id` LEFT JOIN `t_delivery_type_tpl` `deliveryType` ON `t_so_sheet`.`delivery_type` = `deliveryType`.`id` LEFT JOIN `t_pay_type` `payType` ON `t_so_sheet`.`pay_type_id` = `payType`.`id` LEFT JOIN `t_pick_up_point` `pickPoint` ON `t_so_sheet`.`pick_point_id` = `pickPoint`.`id` LEFT JOIN `t_sheet_type` `sheetType` ON `t_so_sheet`.`sheet_type_id` = `sheetType`.`id` LEFT JOIN `t_sys_parameter` `serviceStyle` ON `t_so_sheet`.`service_style` = `serviceStyle`.`id` LIMIT 20

SELECT  distinct `so`.* FROM `t_so_sheet_vip` `sovip` INNER JOIN `t_so_sheet` `so` ON `sovip`.`order_id` = `so`.`id` LEFT JOIN `t_so_sheet` ON `sovip`.`order_id` = `t_so_sheet`.`id` LEFT JOIN `t_vip` `vip` ON `t_so_sheet`.`vip_id` = `vip`.`id` LEFT JOIN `t_sys_region` `city` ON `t_so_sheet`.`city_id` = `city`.`id` LEFT JOIN `t_sys_region` `country` ON `t_so_sheet`.`country_id` = `country`.`id` LEFT JOIN `t_sys_parameter` `deliveryStatus` ON `t_so_sheet`.`delivery_status` = `deliveryStatus`.`id` LEFT JOIN `t_sys_region` `district` ON `t_so_sheet`.`district_id` = `district`.`id` LEFT JOIN `t_sys_parameter` `invoiceType` ON `t_so_sheet`.`invoice_type` = `invoiceType`.`id` LEFT JOIN `t_sys_parameter` `orderStatus` ON `t_so_sheet`.`order_status` = `orderStatus`.`id` LEFT JOIN `t_sys_parameter` `payStatus` ON `t_so_sheet`.`pay_status` = `payStatus`.`id` LEFT JOIN `t_sys_region` `province` ON `t_so_sheet`.`province_id` = `province`.`id` LEFT JOIN `t_delivery_type_tpl` `deliveryType` ON `t_so_sheet`.`delivery_type` = `deliveryType`.`id` LEFT JOIN `t_pay_type` `payType` ON `t_so_sheet`.`pay_type_id` = `payType`.`id` LEFT JOIN `t_pick_up_point` `pickPoint` ON `t_so_sheet`.`pick_point_id` = `pickPoint`.`id` LEFT JOIN `t_sheet_type` `sheetType` ON `t_so_sheet`.`sheet_type_id` = `sheetType`.`id` LEFT JOIN `t_sys_parameter` `serviceStyle` ON `t_so_sheet`.`service_style` = `serviceStyle`.`id` LIMIT 20

select * from t_so_sheet a where exists(select * from t_so_sheet_vip b where b.order_id = a.id )

select * from t_so_sheet_vip;

select * from t_activity
select * from t_product;
select * from t_so_sheet_detail;

SELECT `so`.* FROM `t_so_sheet` `so` LEFT JOIN `t_vip` `vip` ON `so`.`vip_id` = `vip`.`id` LEFT JOIN `t_sys_region` `city` ON `so`.`city_id` = `city`.`id` LEFT JOIN `t_sys_region` `country` ON `so`.`country_id` = `country`.`id` LEFT JOIN `t_sys_parameter` `deliveryStatus` ON `so`.`delivery_status` = `deliveryStatus`.`id` LEFT JOIN `t_sys_region` `district` ON `so`.`district_id` = `district`.`id` LEFT JOIN `t_sys_parameter` `invoiceType` ON `so`.`invoice_type` = `invoiceType`.`id` LEFT JOIN `t_sys_parameter` `orderStatus` ON `so`.`order_status` = `orderStatus`.`id` LEFT JOIN `t_sys_parameter` `payStatus` ON `so`.`pay_status` = `payStatus`.`id` LEFT JOIN `t_sys_region` `province` ON `so`.`province_id` = `province`.`id` LEFT JOIN `t_delivery_type_tpl` `deliveryType` ON `so`.`delivery_type` = `deliveryType`.`id` LEFT JOIN `t_pay_type` `payType` ON `so`.`pay_type_id` = `payType`.`id` LEFT JOIN `t_pick_up_point` `pickPoint` ON `so`.`pick_point_id` = `pickPoint`.`id` LEFT JOIN `t_sheet_type` `sheetType` ON `so`.`sheet_type_id` = `sheetType`.`id` LEFT JOIN `t_sys_parameter` `serviceStyle` ON `so`.`service_style` = `serviceStyle`.`id` 



WHERE `so`.`id` IN (SELECT `order_id` FROM `t_so_sheet_vip` WHERE `vip_id`=2) LIMIT 20

select * from t_sys_region where id in (select id from t_sys_region);

select * from t_refund_sheet_apply;

select * from t_so_sheet

select * from t_vip;

select * from t_product;

alter table t_so_sheet add merchant_id          bigint(20) comment '关联商户编号（订单咨询时可用）';

select * from t_activity

alter table t_so_sheet add constraint fk_so_sheet_merchant_id_ref_vip foreign key (merchant_id)
      references t_vip (id);

select * from t_so_sheet_vip;

select * from t_vip where id = 2;

select * from t_sys_config;

update t_sys_config set value = 

select * from t_sys_app_info;

select * from t_sys_app_release;

alter table t_sys_app_info drop foreign key fk_app_info_ref_app_release;

alter table t_sys_app_info drop column release_id;

alter table t_sys_app_release modify column app_path  varchar(200) comment '应用下载地址';

select * from t_vip;

select * from t_vip_case;

update t_vip_case set audit_status = 3003 where id in (1,2,3)


select * from t_vip_collect;

delete from t_vip_collect;

select * from t_vip_case;

update t_vip_case set sale_price = 100;

update t_vip_case set sale_price = 100 where sale_price is null;
alter table t_vip_case modify sale_price           decimal(20,6) not null comment '销售价';
alter table t_vip_case add   address              varchar(255) not null comment '地址' default '';
alter table t_vip_case add service_date         datetime comment '婚礼时间';

delete from t_vip_collect;

select * from t_activity;

select * from t_vip_case;

SELECT COUNT(*) FROM `t_vip_case` WHERE (`vip_id`='2') AND (`audit_status`=3003)

select * from t_vip_blog;

update t_vip_blog set audit_status = 3003 where id = 1;

SELECT `vipBlog`.* FROM `t_vip_blog` `vipBlog` LEFT JOIN `t_vip` `vip` ON `vipBlog`.`vip_id` = `vip`.`id` LEFT JOIN `t_sys_parameter` `stat` ON `vipBlog`.`status` = `stat`.`id` LEFT JOIN `t_sys_parameter` `blogFlag` ON `vipBlog`.`blog_flag` = `blogFlag`.`id` LEFT JOIN `t_sys_parameter` `auditStatus` ON `vipBlog`.`audit_status` = `auditStatus`.`id` LEFT JOIN `t_sys_user` `auditUser` ON `vipBlog`.`audit_user_id` = `auditUser`.`id` LEFT JOIN `t_vip_blog_type` `blogType` ON `vipBlog`.`blog_type` = `blogType`.`id` 
WHERE (`vipBlog`.`blog_flag`='16002') AND (`vipBlog`.`audit_status`='3003') ORDER BY `create_date` DESC LIMIT 10

SELECT `case`.* FROM `t_vip_case` `case` LEFT JOIN `t_sys_user` `auditUser` ON `case`.`audit_user_id` = `auditUser`.`id` LEFT JOIN `t_sys_parameter` `auditStatus` ON `case`.`audit_status` = `auditStatus`.`id` LEFT JOIN `t_vip_case_type` `type` ON `case`.`type_id` = `type`.`id` LEFT JOIN `t_sys_parameter` `caseFlag` ON `case`.`case_flag` = `caseFlag`.`id` LEFT JOIN `t_sys_parameter` `stat` ON `case`.`status` = `stat`.`id` LEFT JOIN `t_sys_parameter` `isHot` ON `case`.`is_hot` = `isHot`.`id` LEFT JOIN `t_vip` `vip` ON `case`.`vip_id` = `vip`.`id` 
WHERE (`case`.`vip_id`='1') AND (`case`.`audit_status`=3003) ORDER BY `create_date` DESC LIMIT 10

select * from t_product_comment;

drop table t_vip_collect;

select * from t_vip where merchant_flag = 1;

SELECT `vip`.* FROM `t_vip` `vip` LEFT JOIN `t_sys_parameter` `stat` ON `vip`.`status` = `stat`.`id` LEFT JOIN `t_sys_parameter` `auditStat` ON `vip`.`audit_status` = `auditStat`.`id` LEFT JOIN `t_sys_user` `auditStatUsr` ON `vip`.`audit_user_id` = `auditStatUsr`.`id` LEFT JOIN `t_sys_parameter` `emailVerify` ON `vip`.`email_verify_flag` = `emailVerify`.`id` LEFT JOIN `t_vip` `parent` ON `vip`.`parent_id` = `parent`.`id` LEFT JOIN `t_sys_parameter` `mercFlag` ON `vip`.`merchant_flag` = `mercFlag`.`id` 
LEFT JOIN `t_vip_type` `vType` ON `vip`.`vip_type_id` = `vType`.`id` LEFT JOIN `t_sys_parameter` `mobileVerify` ON `vip`.`mobile_verify_flag` = `mobileVerify`.`id` LEFT JOIN `t_vip_rank` `rank` ON `vip`.`rank_id` = `rank`.`id` LEFT JOIN `t_sys_parameter` `sex` ON `vip`.`sex` = `sex`.`id` 
WHERE (`vip`.`merchant_flag`=1) AND (`vip`.`audit_status`=3003) ORDER BY `vip_name` LIMIT 10

update t_vip set `audit_status`=3003 where id in (6,7,9);

create table t_vip_collect
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   vip_id               bigint(20) not null comment '会员编号',
   product_id           bigint(20) comment '关联产品',
   package_id           bigint(20) comment '关联套餐',
   case_id              bigint(20) comment '关联案例',
   blog_id              bigint(20) comment '关联话题',
   collect_date         datetime not null comment '收藏时间',
   collect_type         bigint(20) not null comment '收藏类型（话题，商家，产品，团体服务，案例）',
   ref_vip_id           bigint(20) comment '关注商家',
   primary key (id)
);

alter table t_vip_collect comment '会员收藏';

alter table t_vip_collect add constraint fk_vip_collect_ref_activity foreign key (package_id)
      references t_activity (id);

alter table t_vip_collect add constraint fk_vip_collect_ref_case foreign key (case_id)
      references t_vip_case (id);

alter table t_vip_collect add constraint fk_vip_collect_ref_product foreign key (product_id)
      references t_product (id);

alter table t_vip_collect add constraint fk_vip_collect_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_collect add constraint fk_vip_collect_refvip_ref_vip foreign key (ref_vip_id)
      references t_vip (id);

alter table t_vip_collect add constraint fk_vip_collect_type_ref_param foreign key (collect_type)
      references t_sys_parameter (id);


alter table t_activity add market_price         decimal(20,6) comment '市场价';

select * from t_vip_blog_cmt;

alter table t_act_package_product drop column sale_price;

select * from t_sys_notify;

select * from t_vip_type;

select * from t_vip_blog_cmt;

select b.order_status,b.*,a.* from t_so_sheet_vip a,t_so_sheet b where a.order_id = b.id and  a.vip_id = 2;

update t_so_sheet set order_status = 5008 where id = 22 

select * from t_vip_collect;



SELECT vipBlogCmt.*
FROM `t_vip_blog_cmt` `vipBlogCmt` LEFT JOIN `t_vip_blog` `blog` ON `vipBlogCmt`.`blog_id` = `blog`.`id` LEFT JOIN `t_vip` `vip` ON `vipBlogCmt`.`vip_id` = `vip`.`id` LEFT JOIN `t_sys_parameter` `stat` ON `vipBlogCmt`.`status` = `stat`.`id` LEFT JOIN `t_vip_blog_cmt` `parent` ON `vipBlogCmt`.`parent_id` = `parent`.`id` 
WHERE (`vipBlogCmt`.`blog_id`='6') AND (`vipBlogCmt`.`status`=1) AND (`vipBlogCmt`.`parent_id`='3')

select * from t_vip_blog_cmt

update t_vip_blog_cmt set blog_id = 6 ,parent_id = 3 , status = 1 where id = 1;

select * from t_so_sheet_vip where order_id = 1;

alter table t_so_sheet drop column message;

20161203

alter table t_so_sheet  drop foreign key fk_so_sheet_ref_st_type;
alter table t_so_sheet  drop foreign key fk_so_sheet_case_id_ref_org_case;
alter table t_so_sheet  drop foreign key fk_so_sheet_merchant_id_ref_vip;

alter table t_so_sheet drop column sheet_type_id;
alter table t_so_sheet drop column budget_amount;
alter table t_so_sheet drop column related_service;
alter table t_so_sheet drop column service_style;
alter table t_so_sheet drop column related_case_id;
alter table t_so_sheet drop column merchant_id;


create table t_quotation
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   code                 varchar(30) not null comment '咨询编号',
   vip_id               bigint(20) not null comment '会员编号',
   order_amt            decimal(20,6) comment '报价金额',
   deposit_amount       decimal(20,6) comment '最少定金金额',
   create_date          datetime not null comment '提交日期',
   update_date          datetime not null comment '修改日期',
   memo                 varchar(400) comment '备注',
   status               bigint(20) not null comment '咨询状态：待回复（用户提交咨询，商户待回复），已回复（商户已回复），已完成（用户已生成订单)',
   consignee            varchar(30) not null comment '联系人',
   mobile               varchar(20) not null comment '联系手机号码',
   service_date         datetime not null comment '服务时间',
   budget_amount        decimal(20,6) comment '婚礼预算',
   related_service      varchar(60) comment '需要人员（多选）（婚礼策划师，摄影师，摄像师，化妆师，主持人）',
   service_style        varchar(60) comment '婚礼类型（单选）（室内，室外）',
   merchant_id          bigint(20) not null comment '关联商户编号',
   primary key (id)
);

alter table t_quotation comment '订单咨询（报价单）';

create unique index Index_quotation_code on t_quotation
(
   code
);

alter table t_quotation add constraint fk_quotation_merchant_id_ref_merch foreign key (merchant_id)
      references t_vip (id);

alter table t_quotation add constraint fk_quotation_service_style_ref_param foreign key (service_style)
      references t_sys_parameter (id);

alter table t_quotation add constraint fk_quotation_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_quotation add constraint fk_quotation_vip_id_ref_vip foreign key (vip_id)
      references t_vip (id);


create table t_quotation_detail
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   quotation_id         bigint(20) not null comment '关联报价单编号',
   product_id           bigint(20) not null comment '关联产品编号',
   quantity             int not null comment '购买数量',
   price                decimal(20,6) not null comment '单价',
   amount               decimal(20,6) comment '金额',
   primary key (id)
);

alter table t_quotation_detail comment '订单咨询明细（报价单明细）';

alter table t_quotation_detail add constraint fk_quotatioin_detail_ref_quotation foreign key (quotation_id)
      references t_quotation (id);

alter table t_quotation_detail add constraint fk_quotation_detail_prod_ref_prod foreign key (product_id)
      references t_product (id);


update t_sheet_type set code = 'qu',prefix = 'qu',name = '报价单' where id = 2;

insert into t_sys_parameter_type(id,name,description) values(29,'报价单状态',null);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(29001,29,'待回复',null,1);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(29002,29,'已回复',null,2);
insert into t_sys_parameter(id,type_id,param_val,description,seq_id) values(29003,29,'已执行',null,3);


alter table t_so_sheet add quotation_id         bigint(20) comment '关联报价单编号';

alter table t_so_sheet add constraint fk_so_sheet_ref_quotation foreign key (quotation_id)
      references t_quotation (id);




select * from t_sheet_type;

Name	Code	Data Type	Length	Precision	Primary	Foreign Key	Mandatory
budget_amount	budget_amount	decimal(20,6)	20	6	FALSE	FALSE	FALSE
related_service	related_service	varchar(60)	60		FALSE	FALSE	FALSE
service_style	service_style	varchar(60)	60		FALSE	FALSE	FALSE
related_case_id	related_case_id	bigint(20)	20		FALSE	TRUE	FALSE
merchant_id	merchant_id	bigint(20)	20		FALSE	TRUE	FALSE


select * from t_vip where merchant_flag = 0;


*/