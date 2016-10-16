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



select * from t_sys_region limit 0,100


*/