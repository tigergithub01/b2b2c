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



*/