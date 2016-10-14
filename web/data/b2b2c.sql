/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2016/10/14 11:30:37                          */
/*==============================================================*/


drop table if exists t_act_buy_discount;

drop table if exists t_act_buy_giving_detail;

drop table if exists t_act_buy_giving_detail_pkg;

drop table if exists t_act_exchange_product;

drop table if exists t_act_package_product;

drop table if exists t_act_scope;

drop table if exists t_act_special_price;

drop table if exists t_activity;

drop table if exists t_delivery_type;

drop table if exists t_delivery_type_area;

drop table if exists t_delivery_type_area_region;

drop index Index_delivery_code on t_delivery_type_tpl;

drop table if exists t_delivery_type_tpl;

drop index Index_out_code on t_out_stock_sheet;

drop table if exists t_out_stock_sheet;

drop table if exists t_out_stock_sheet_detail;

drop index Index_pay_type_code on t_pay_type;

drop table if exists t_pay_type;

drop table if exists t_pick_up_point;

drop table if exists t_pick_up_point_region;

drop table if exists t_product;

drop table if exists t_product_brand;

drop table if exists t_product_comment;

drop table if exists t_product_comment_photo;

drop table if exists t_product_comment_reply;

drop table if exists t_product_gallery;

drop table if exists t_product_group;

drop table if exists t_product_home_ads;

drop table if exists t_product_prod_sale;

drop table if exists t_product_prod_sale_prop;

drop table if exists t_product_prop;

drop table if exists t_product_stock;

drop table if exists t_product_type;

drop table if exists t_product_type_prop;

drop table if exists t_product_type_prop_val;

drop table if exists t_product_vip_price;

drop table if exists t_refund_sheet;

drop table if exists t_refund_sheet_apply;

drop table if exists t_return_apply;

drop table if exists t_return_apply_detail;

drop table if exists t_return_sheet;

drop table if exists t_return_sheet_detail;

drop table if exists t_sheet_log;

drop index Index_sheet_type_code on t_sheet_type;

drop table if exists t_sheet_type;

drop table if exists t_shopping_cart;

drop index Index_so_code on t_so_sheet;

drop table if exists t_so_sheet;

drop table if exists t_so_sheet_coupon;

drop table if exists t_so_sheet_detail;

drop table if exists t_so_sheet_pay_info;

drop table if exists t_sys_ad_info;

drop table if exists t_sys_app_info;

drop table if exists t_sys_app_release;

drop table if exists t_sys_article;

drop table if exists t_sys_article_type;

drop table if exists t_sys_audit_log;

drop table if exists t_sys_config;

drop table if exists t_sys_config_detail;

drop table if exists t_sys_feedback;

drop index Index_module_code on t_sys_module;

drop table if exists t_sys_module;

drop table if exists t_sys_notify;

drop table if exists t_sys_notify_log;

drop index Index_op_code on t_sys_operation;

drop table if exists t_sys_operation;

drop table if exists t_sys_operation_log;

drop table if exists t_sys_parameter;

drop table if exists t_sys_parameter_type;

drop table if exists t_sys_region;

drop table if exists t_sys_relative_module;

drop table if exists t_sys_role;

drop table if exists t_sys_role_rights;

drop table if exists t_sys_role_user;

drop index Index_user_id on t_sys_user;

drop table if exists t_sys_user;

drop table if exists t_sys_verify_code;

drop table if exists t_sys_warehouse;

drop table if exists t_sys_warehouse_region;

drop index Index_vip_id on t_vip;

drop table if exists t_vip;

drop table if exists t_vip_address;

drop table if exists t_vip_blog;

drop table if exists t_vip_blog_cmt;

drop table if exists t_vip_blog_likes;

drop table if exists t_vip_blog_photo;

drop table if exists t_vip_blog_type;

drop table if exists t_vip_case;

drop table if exists t_vip_case_detail;

drop table if exists t_vip_case_photo;

drop table if exists t_vip_case_type;

drop table if exists t_vip_case_type_prop;

drop table if exists t_vip_case_type_prop_val;

drop table if exists t_vip_collect;

drop table if exists t_vip_concern;

drop table if exists t_vip_coupon;

drop table if exists t_vip_coupon_log;

drop table if exists t_vip_coupon_type;

drop table if exists t_vip_extend;

drop index idx_vip_module_code on t_vip_module;

drop table if exists t_vip_module;

drop table if exists t_vip_operation_log;

drop table if exists t_vip_org_gallery;

drop table if exists t_vip_organization;

drop table if exists t_vip_product_type;

drop table if exists t_vip_rank;

drop table if exists t_vip_type;

/*==============================================================*/
/* Table: t_act_buy_discount                                    */
/*==============================================================*/
create table t_act_buy_discount
(
   id                   bigint(20) not null auto_increment comment '主键',
   act_id               bigint(20) not null comment '关联买赠主产品信息',
   buy_amount           decimal(20,6) not null comment '购买金额',
   discount             decimal(20,6) not null comment '折扣金额，折扣率',
   is_double            bigint(20) not null comment '是否按倍数折扣',
   max_discount         decimal(20,6) not null comment '最大折扣金额，折扣率',
   primary key (id)
);

alter table t_act_buy_discount comment '满减金额，满折扣率';

/*==============================================================*/
/* Table: t_act_buy_giving_detail                               */
/*==============================================================*/
create table t_act_buy_giving_detail
(
   id                   bigint(20) not null auto_increment comment '主键',
   act_id               bigint(20) not null comment '关联活动编号',
   buy_amount           decimal(20,6) not null comment '购买数量,购满金额',
   giving_number        int not null comment '赠送数量',
   is_double_give       bigint(20) not null comment '是否按倍数赠送如买二赠一，买四赠二',
   giving_product_id    bigint(20) not null comment '赠送商品编号',
   max_give_number      int not null comment '最大赠送数量',
   primary key (id)
);

alter table t_act_buy_giving_detail comment '产品买赠详情';

/*==============================================================*/
/* Table: t_act_buy_giving_detail_pkg                           */
/*==============================================================*/
create table t_act_buy_giving_detail_pkg
(
   id                   bigint(20) not null auto_increment comment '主键',
   buy_giving_detail_id bigint(20) not null comment '关联买增商品信息',
   giving_number        int not null comment '赠送数量',
   giving_product_id    bigint(20) not null comment '赠送商品编号',
   primary key (id)
);

alter table t_act_buy_giving_detail_pkg comment '赠送套餐商品';

/*==============================================================*/
/* Table: t_act_exchange_product                                */
/*==============================================================*/
create table t_act_exchange_product
(
   id                   bigint(20) not null auto_increment comment '主键',
   product_id           bigint(20) not null comment '关联产品编号',
   exchange_integral    int not null comment '可使用积分数',
   is_exchange          bigint(20) not null comment '是否可以兑换',
   primary key (id)
);

alter table t_act_exchange_product comment '积分换购商品';

/*==============================================================*/
/* Table: t_act_package_product                                 */
/*==============================================================*/
create table t_act_package_product
(
   id                   bigint(20) not null auto_increment comment '主键',
   act_id               bigint(20) not null comment '关联活动编号',
   product_id           bigint(20) not null comment '关联产品编号',
   sale_price           decimal(20,6) not null comment '原价',
   package_price        decimal(20,6) not null comment '套装价',
   quantity             int not null comment '数量',
   primary key (id)
);

alter table t_act_package_product comment '优惠套装';

/*==============================================================*/
/* Table: t_act_scope                                           */
/*==============================================================*/
create table t_act_scope
(
   id                   bigint(20) not null auto_increment comment '主键',
   act_id               bigint(20) not null comment '关联活动编号',
   brand_id             bigint(20) comment '关联品牌编号',
   product_id           bigint(20) comment '关联产品编号',
   product_type_id      bigint(20) comment '关联产品分类编号',
   primary key (id)
);

alter table t_act_scope comment '参与促销品牌,产品，分类';

/*==============================================================*/
/* Table: t_act_special_price                                   */
/*==============================================================*/
create table t_act_special_price
(
   id                   bigint(20) not null auto_increment comment '主键',
   act_id               bigint(20) not null comment '关联活动编号',
   product_id           bigint(20) not null comment '关联产品编号',
   sale_price           decimal(20,6) not null comment '原价',
   special_price        decimal(20,6) not null comment '特价',
   buy_limit_num        int not null comment '限购数量',
   primary key (id)
);

alter table t_act_special_price comment '特价商品促销';

/*==============================================================*/
/* Table: t_activity                                            */
/*==============================================================*/
create table t_activity
(
   id                   bigint(20) not null auto_increment comment '主键',
   name                 varchar(30) not null comment '买赠活动名称',
   activity_type        bigint(20) not null comment '活动类型（特价促销，优惠套装，产品满几件赠几件，满金额赠送产品、折扣、满金额减金额）',
   activity_scope       bigint(20) comment '是否全场参与活动',
   start_time           datetime not null comment '开始时间',
   end_date             datetime not null comment '结束时间',
   description          varchar(255) comment '活动描述',
   package_price        decimal(20,6) comment '套装价',
   deposit_amount       decimal(20,6) comment '最少定金金额',
   buy_limit_num        int comment '限购数量',
   vip_id               bigint(20) not null comment '关联商户编号',
   img_url              varchar(255) comment '图片（放大后查看）(上传商品图片后自动加入商品相册）',
   thumb_url            varchar(255) comment '缩略图',
   img_original         varchar(255) comment '原图',
   primary key (id)
);

alter table t_activity comment '促销活动';

/*==============================================================*/
/* Table: t_delivery_type                                       */
/*==============================================================*/
create table t_delivery_type
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   tpl_id               bigint(20) not null comment '配送方式名称',
   vip_id               bigint(20) not null comment '关联商户编号',
   description          varchar(255) comment '描述',
   status               bigint(20) not null comment '是否启用？(1:是；0:否)',
   primary key (id)
);

alter table t_delivery_type comment '配送方式';

/*==============================================================*/
/* Table: t_delivery_type_area                                  */
/*==============================================================*/
create table t_delivery_type_area
(
   id                   bigint(20) not null auto_increment comment '主键',
   name                 varchar(30) not null comment '配送区域名称',
   delivery_id          bigint(20) not null comment '关联配送方式',
   configure            text not null comment '对应的计费规则',
   primary key (id)
);

alter table t_delivery_type_area comment '配送区域';

/*==============================================================*/
/* Table: t_delivery_type_area_region                           */
/*==============================================================*/
create table t_delivery_type_area_region
(
   id                   bigint(20) not null auto_increment comment '主键',
   delivery_area_id     bigint(20) not null comment '关联配送方式区域',
   region_id            bigint(20) not null comment '对应区域',
   primary key (id)
);

alter table t_delivery_type_area_region comment '配送区域覆盖地区';

/*==============================================================*/
/* Table: t_delivery_type_tpl                                   */
/*==============================================================*/
create table t_delivery_type_tpl
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   code                 varchar(30) not null comment '配送方式唯一编码',
   name                 varchar(60) not null comment '配送方式名称',
   print_tpl            text comment '打印模板',
   description          varchar(255) comment '描述',
   status               bigint(20) not null comment '是否有效(1:是；0:否)',
   primary key (id)
);

alter table t_delivery_type_tpl comment '配送方式模板';

/*==============================================================*/
/* Index: Index_delivery_code                                   */
/*==============================================================*/
create unique index Index_delivery_code on t_delivery_type_tpl
(
   code
);

/*==============================================================*/
/* Table: t_out_stock_sheet                                     */
/*==============================================================*/
create table t_out_stock_sheet
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   sheet_type_id        bigint(20) not null comment '单据类型',
   code                 varchar(30) not null comment '发货单编号（根据规则自动生成）',
   order_id             bigint(20) not null comment '关联订单编号',
   user_id              bigint(20) not null comment '制单人',
   vip_id               bigint(20) not null comment '关联商户编号',
   sheet_date           datetime not null comment '单据生成时间',
   status               bigint(20) not null comment '发货单状态（未发货、已发货）',
   delivery_type        bigint(20) not null comment '配送方式',
   delivery_no          varchar(60) not null comment '快递单号',
   primary key (id)
);

alter table t_out_stock_sheet comment '发货单';

/*==============================================================*/
/* Index: Index_out_code                                        */
/*==============================================================*/
create unique index Index_out_code on t_out_stock_sheet
(
   code
);

/*==============================================================*/
/* Table: t_out_stock_sheet_detail                              */
/*==============================================================*/
create table t_out_stock_sheet_detail
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   out_stock_id         bigint(20) not null comment '关联发货单编号',
   product_id           bigint(20) not null comment '关联产品编号',
   order_quantity       int comment '订单数量',
   out_quantity         int comment '本次发货数量',
   primary key (id)
);

alter table t_out_stock_sheet_detail comment '发货明细表';

/*==============================================================*/
/* Table: t_pay_type                                            */
/*==============================================================*/
create table t_pay_type
(
   id                   bigint(20) not null auto_increment comment '主键',
   code                 varchar(30) not null comment '支付方式唯一编码',
   name                 varchar(60) not null comment '支付方式名称',
   rate                 decimal(20,6) comment '费率',
   description          varchar(255) comment '描述',
   configure            text comment '对应配置信息',
   status               bigint(20) not null comment '状态（1:有效、0:停用）',
   is_cod               bigint(20) not null comment '是否货到付款（1:是、0:否）',
   primary key (id)
);

alter table t_pay_type comment '支付方式';

/*==============================================================*/
/* Index: Index_pay_type_code                                   */
/*==============================================================*/
create unique index Index_pay_type_code on t_pay_type
(
   code
);

/*==============================================================*/
/* Table: t_pick_up_point                                       */
/*==============================================================*/
create table t_pick_up_point
(
   id                   bigint(20) not null auto_increment comment '主键',
   vip_id               bigint(20) not null comment '关联商户编号',
   name                 varchar(50) not null comment '自提点名称',
   address              varchar(100) not null comment '自提点地址',
   status               bigint(20) not null comment '是否启用：1、是；0、否；',
   primary key (id)
);

alter table t_pick_up_point comment '自提点';

/*==============================================================*/
/* Table: t_pick_up_point_region                                */
/*==============================================================*/
create table t_pick_up_point_region
(
   id                   bigint(20) not null auto_increment comment '主键',
   point_id             bigint(20) not null comment '自提点编号',
   region_id            bigint(20) not null comment '区域编号',
   primary key (id)
);

alter table t_pick_up_point_region comment '自提点管辖区域';

/*==============================================================*/
/* Table: t_product                                             */
/*==============================================================*/
create table t_product
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   code                 varchar(30) comment '产品唯一编码',
   name                 varchar(60) not null comment '产品名称',
   type_id              bigint(20) not null comment '产品分类',
   brand_id             bigint(20) comment '品牌',
   market_price         decimal(20,6) not null comment '市场价',
   sale_price           decimal(20,6) not null comment '销售价',
   deposit_amount       decimal(20,6) not null comment '最少定金金额',
   description          text comment '产品描述',
   is_on_sale           bigint(20) not null comment '产品状态（1:正常销售、0:下架）',
   is_hot               bigint(20) not null comment '是否热销商品？1：是；0：否',
   audit_status         bigint(20) not null comment '审核状态：未审核，审核不通过，审核通过',
   audit_user_id        bigint(20) comment '审核人',
   audit_date           datetime comment '审核时间',
   stock_quantity       decimal(20,6) comment '库存数量',
   safety_quantity      decimal(20,6) comment '安全库存',
   can_return_flag      bigint(20) not null comment '是否能退货（1:可以、0:不可以）',
   return_days          bigint(20) comment '可退货天数(可以退货时才设置此字段)',
   return_desc          text comment '退货规则描述',
   cost_price           decimal(20,6) comment '成本价',
   vip_id               bigint(20) not null comment '关联商户编号',
   keywords             varchar(100) comment '商品关键字，供检索用',
   is_free_shipping     bigint(20) not null comment '是否免运费商品',
   give_integral        int(10) comment '赠送消费积分数',
   rank_integral        int(10) comment '赠送等级积分数',
   integral             int(10) comment '积分购买金额',
   relative_module      bigint(20) comment '关联版式',
   bonus                int(10) comment '红包购买金额',
   product_weight       decimal(20,6) comment '商品重量',
   product_weight_unit  bigint(20) comment '商品重量单位',
   product_group_id     bigint(20) comment '产品分组编号',
   img_url              varchar(255) comment '图片（放大后查看）(上传商品图片后自动加入商品相册）',
   thumb_url            varchar(255) comment '缩略图',
   img_original         varchar(255) comment '原图',
   primary key (id)
);

alter table t_product comment '产品信息表';

/*==============================================================*/
/* Table: t_product_brand                                       */
/*==============================================================*/
create table t_product_brand
(
   id                   bigint(20) not null auto_increment comment '主键',
   name                 varchar(30) not null comment '品牌名称',
   description          varchar(200) comment '品牌描述',
   brand_logo           varchar(200) comment '品牌logo',
   primary key (id)
);

alter table t_product_brand comment '产品品牌';

/*==============================================================*/
/* Table: t_product_comment                                     */
/*==============================================================*/
create table t_product_comment
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   product_id           bigint(20) comment '关联产品编号（评价商品时写此字段)',
   vip_id               bigint(20) not null comment '会员编号',
   cmt_rank_id          bigint(20) comment '评价等级（好评、中评、差评）(也可以是星级1：差；2，3：中，4，5：好）',
   content              varchar(300) not null comment '评价内容',
   comment_date         datetime not null comment '评价时间',
   ip_addr              varchar(15) not null comment '评价IP地址',
   status               bigint(20) not null comment '是否显示？1：是；0：否',
   parent_id            bigint(20) comment '上级评价',
   primary key (id)
);

alter table t_product_comment comment '产品（店铺）评价';

/*==============================================================*/
/* Table: t_product_comment_photo                               */
/*==============================================================*/
create table t_product_comment_photo
(
   id                   bigint(20) not null auto_increment comment '主键',
   comment_id           bigint(20) not null comment '关联评价编号',
   img_url              varchar(255) not null comment '图片（放大后查看）',
   thumb_url            varchar(255) not null comment '缩略图',
   img_original         varchar(255) not null comment '原始图片',
   primary key (id)
);

alter table t_product_comment_photo comment '评价图片';

/*==============================================================*/
/* Table: t_product_comment_reply                               */
/*==============================================================*/
create table t_product_comment_reply
(
   id                   bigint(20) not null auto_increment comment '主键',
   content              varchar(255) not null comment '回复内容',
   comment_id           bigint(20) not null comment '关联评价编号',
   reply_date           datetime not null comment '回复日期',
   user_id              bigint(20) not null comment '关联用户编号',
   primary key (id)
);

alter table t_product_comment_reply comment '产品评价回复';

/*==============================================================*/
/* Table: t_product_gallery                                     */
/*==============================================================*/
create table t_product_gallery
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   product_id           bigint(20) not null comment '关联产品编号',
   img_url              varchar(255) not null comment '图片（放大后查看）',
   thumb_url            varchar(255) not null comment '缩略图',
   img_original         varchar(255) not null comment '原图',
   primary_flag         bigint(20) comment '是否设置为主图(1：是；0：否),不需要此字段',
   primary key (id)
);

alter table t_product_gallery comment '产品图片';

/*==============================================================*/
/* Table: t_product_group                                       */
/*==============================================================*/
create table t_product_group
(
   id                   bigint(20) not null auto_increment comment '主键',
   name                 varchar(50) not null comment '分组名称',
   primary key (id)
);

alter table t_product_group comment '产品分组（用来实现销售属性选择）';

/*==============================================================*/
/* Table: t_product_home_ads                                    */
/*==============================================================*/
create table t_product_home_ads
(
   id                   bigint(20) not null auto_increment comment '主键',
   product_id           bigint(20) not null comment '关联产品编号',
   sequence_id          bigint(20) not null comment '序号',
   primary key (id)
);

alter table t_product_home_ads comment '商户首页产品列表(此表是否需要待定）';

/*==============================================================*/
/* Table: t_product_prod_sale                                   */
/*==============================================================*/
create table t_product_prod_sale
(
   id                   bigint(20) not null auto_increment comment '主键',
   product_id           bigint(20) not null comment '商品编号',
   sale_price           decimal(20,6) not null comment '批发价',
   stock_quantity       decimal(20,6) not null comment '库存',
   primary key (id)
);

alter table t_product_prod_sale comment '商品销售-产品';

/*==============================================================*/
/* Table: t_product_prod_sale_prop                              */
/*==============================================================*/
create table t_product_prod_sale_prop
(
   id                   bigint(20) not null auto_increment comment '主键',
   attr_group_id        bigint(20) not null comment '销售属性产品编号',
   prop_id              bigint(20) not null comment '商品属性编号',
   primary key (id)
);

alter table t_product_prod_sale_prop comment '销售属性定义（如果存在促销的时候，多属性产品很难管理，这个要考虑）';

/*==============================================================*/
/* Table: t_product_prop                                        */
/*==============================================================*/
create table t_product_prop
(
   id                   bigint(20) not null auto_increment comment '主键',
   product_id           bigint(20) not null comment '产品编号',
   prop_id              bigint(20) not null comment '属性编号',
   prop_val             bigint(20) not null comment '属性值',
   prop_input_val       varchar(50) comment '属性输入值',
   primary key (id)
);

alter table t_product_prop comment '产品普通属性';

/*==============================================================*/
/* Table: t_product_stock                                       */
/*==============================================================*/
create table t_product_stock
(
   id                   bigint(20) not null auto_increment comment '主键',
   warehouse_id         bigint(20) not null comment '关联仓库',
   product_id           bigint(20) not null comment '关联产品编号',
   stock_quantity       decimal(20,6) not null comment '仓库库存',
   primary key (id)
);

alter table t_product_stock comment '产品分仓库库存';

/*==============================================================*/
/* Table: t_product_type                                        */
/*==============================================================*/
create table t_product_type
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   name                 varchar(60) not null comment '分类名称',
   parent_id            bigint(20) comment '上级分类编号',
   description          varchar(600) comment '分类描述',
   seq_id               int comment '显示顺序',
   primary key (id)
);

alter table t_product_type comment '产品分类表';

/*==============================================================*/
/* Table: t_product_type_prop                                   */
/*==============================================================*/
create table t_product_type_prop
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   product_type_id      bigint(20) not null comment '关联产品类别编号',
   prop_name            varchar(60) not null comment '属性名称',
   is_sale_prop         bigint(20) not null comment '是否销售属性?1:是；0：否',
   is_required          bigint(20) not null comment '是否必填项？1：是；0：否',
   input_type           bigint(20) not null comment '录入类型：输入，从列表中选取，日期选择（可暂时不做）',
   multi_select         bigint(20) not null comment '是否可以多选？1：是，0：否',
   primary key (id)
);

alter table t_product_type_prop comment '产品分类属性';

/*==============================================================*/
/* Table: t_product_type_prop_val                               */
/*==============================================================*/
create table t_product_type_prop_val
(
   id                   bigint(20) not null auto_increment comment '主键',
   prop_id              bigint(20) not null comment '对应属性编号',
   prop_value           varchar(50) not null comment '对应属性值',
   primary key (id)
);

alter table t_product_type_prop_val comment '商品属性值（主要针对销售属性，销售属性为单选属性）';

/*==============================================================*/
/* Table: t_product_vip_price                                   */
/*==============================================================*/
create table t_product_vip_price
(
   id                   bigint(20) not null auto_increment comment '主键',
   product_id           bigint(20) not null comment '产品编号',
   vip_rank_id          bigint(20) not null comment '会员等级',
   price                decimal(20,6) not null comment '价格',
   primary key (id)
);

alter table t_product_vip_price comment '商品会员价';

/*==============================================================*/
/* Table: t_refund_sheet                                        */
/*==============================================================*/
create table t_refund_sheet
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   sheet_type_id        bigint(20) not null comment '单据类型',
   refund_apply_id      bigint(20) comment '关联退款申请编号',
   code                 varchar(30) not null comment '退款单编号（根据单据规则自动生成）',
   order_id             bigint(20) not null comment '关联订单编号',
   return_id            bigint(20) comment '关联退货单编号',
   user_id              bigint(20) not null comment '制单人',
   sheet_date           datetime not null comment '制单时间',
   need_return_amt      decimal(20,6) comment '待退款金额',
   return_amt           decimal(20,6) comment '实际退款金额',
   memo                 varchar(400) comment '备注',
   status               bigint(20) not null comment '退款单状态（待退款、已退款）',
   vip_id               bigint(20) not null comment '关联商户编号',
   primary key (id)
);

alter table t_refund_sheet comment '退款单';

/*==============================================================*/
/* Table: t_refund_sheet_apply                                  */
/*==============================================================*/
create table t_refund_sheet_apply
(
   id                   bigint(20) not null auto_increment comment '主键',
   sheet_type_id        bigint(20) not null comment '单据类型（退款申请单）',
   vip_id               bigint(20) comment '关联会员编号',
   order_id             bigint(20) not null comment '订单编号',
   reason               varchar(255) not null comment '申请退款原因',
   status               bigint(20) comment '退款申请状态（审核中，退款处理中[审核通过]，已退款，审核不通过，已撤销）',
   primary key (id)
);

alter table t_refund_sheet_apply comment '退款申请';

/*==============================================================*/
/* Table: t_return_apply                                        */
/*==============================================================*/
create table t_return_apply
(
   id                   bigint(20) not null auto_increment comment '主键',
   sheet_type_id        bigint(20) not null comment '退货申请单',
   apply_date           datetime not null comment '申请日期',
   vip_id               bigint(20) not null comment '申请会员',
   order_id             bigint(20) not null comment '关联订单编号',
   reason               varchar(255) not null comment '退货申请原因',
   status               bigint(20) not null comment '审核中，退货处理中(审核通过)，已退货，审核不通过，用户撤销',
   primary key (id)
);

alter table t_return_apply comment '退换货申请';

/*==============================================================*/
/* Table: t_return_apply_detail                                 */
/*==============================================================*/
create table t_return_apply_detail
(
   id                   bigint(20) not null auto_increment comment '主键',
   return_apply_id      bigint(20) not null comment '退换货申请编号',
   product_id           bigint(20) not null comment '退换货产品编号',
   quantity             int not null comment '申请退换货数量',
   primary key (id)
);

alter table t_return_apply_detail comment '退换货申请';

/*==============================================================*/
/* Table: t_return_sheet                                        */
/*==============================================================*/
create table t_return_sheet
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   sheet_type_id        bigint(20) not null comment '单据类型',
   return_apply_id      bigint(20) comment '退货申请单号',
   code                 varchar(30) not null comment '退货单编号（根据单据规则自动生成）',
   order_id             bigint(20) not null comment '关联订单编号',
   out_id               bigint(20) not null comment '关联发货单编号',
   user_id              bigint(20) not null comment '制单人',
   sheet_date           datetime not null comment '制单时间',
   return_amt           decimal(20,6) comment '本次退货金额',
   memo                 varchar(400) comment '备注',
   status               bigint(20) not null comment '退货单状态（待退货、已完成）',
   vip_id               bigint(20) not null comment '关联商户编号',
   primary key (id)
);

alter table t_return_sheet comment '退货单';

/*==============================================================*/
/* Table: t_return_sheet_detail                                 */
/*==============================================================*/
create table t_return_sheet_detail
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   return_id            bigint(20) not null comment '关联退货单编号',
   product_id           bigint(20) not null comment '关联产品编号',
   out_quantity         int comment '发货数量',
   return_quantity      int comment '本次退货数量',
   primary key (id)
);

alter table t_return_sheet_detail comment '退货明细表';

/*==============================================================*/
/* Table: t_sheet_log                                           */
/*==============================================================*/
create table t_sheet_log
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   sheet_type_id        bigint(20) not null comment '单据类型（订单、发货单、退货单、退款单）',
   ref_sheet_id         bigint(20) not null comment '关联单据编号',
   user_id              bigint(20) comment '关联操作用户编号',
   vip_id               bigint(20) comment '关联操作会员编号',
   action_date          datetime not null comment '操作时间',
   description          varchar(200) comment '备注',
   primary key (id)
);

alter table t_sheet_log comment '单据操作日志表';

/*==============================================================*/
/* Table: t_sheet_type                                          */
/*==============================================================*/
create table t_sheet_type
(
   id                   bigint(20) not null comment '主键编号',
   code                 varchar(10) not null comment '单据唯一编码',
   name                 varchar(60) not null comment '单据名称',
   prefix               varchar(10) not null comment '单据前缀',
   date_format          varchar(20) not null comment '日期格式(yyyyMMdd)',
   sep                  varchar(10) comment '分隔符(Null、’-’)',
   seq_length           bigint(20) not null comment '序列长度',
   cur_seq              bigint(20) not null comment '当前序列号',
   primary key (id)
);

alter table t_sheet_type comment '单据类型';

/*==============================================================*/
/* Index: Index_sheet_type_code                                 */
/*==============================================================*/
create unique index Index_sheet_type_code on t_sheet_type
(
   code
);

/*==============================================================*/
/* Table: t_shopping_cart                                       */
/*==============================================================*/
create table t_shopping_cart
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   session_id           varchar(32) not null comment '会话编号',
   vip_id               bigint(20) comment '会员编号',
   product_id           bigint(20) comment '关联产品编号',
   package_id           bigint(20) comment '关联套餐编号',
   quantity             int not null comment '购买数量',
   price                decimal(20,6) comment '单价',
   is_checked           bigint(20) comment '是否选中',
   create_date          datetime not null comment '创建日期',
   update_date          datetime comment '修改日期',
   is_gift              bigint(20) not null comment '是否赠品',
   parent_id            bigint(20) comment '赠品对应的原品',
   primary key (id)
);

alter table t_shopping_cart comment '购物车';

/*==============================================================*/
/* Table: t_so_sheet                                            */
/*==============================================================*/
create table t_so_sheet
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   sheet_type_id        bigint(20) not null comment '订单类型（普通订单，定制订单）',
   code                 varchar(30) not null comment '订单编号(so-年月日-顺序号，根据单据设置进行生成)',
   vip_id               bigint(20) not null comment '会员编号',
   order_amt            decimal(20,6) not null comment '订单待支付费用',
   order_quantity       int not null comment '产品数量（所有商品数量汇总）',
   goods_amt            decimal(20,6) not null comment '商品总金额',
   deliver_fee          decimal(20,6) not null comment '运费',
   order_date           datetime not null comment '订单提交日期',
   delivery_date        datetime comment '发货日期',
   delivery_type        bigint(20) not null comment '配送方式',
   pay_type_id          bigint(20) comment '支付方式',
   pay_date             datetime comment '付款日期',
   delivery_no          varchar(60) comment '快递单号',
   pick_point_id        bigint(20) comment '自提点',
   paid_amt             decimal(20,6) comment '已付款金额',
   integral             bigint(20) not null comment '消耗积分',
   integral_money       decimal(20,6) not null comment '积分折合金额',
   coupon               decimal(20,6) not null comment '优惠券消耗金额',
   discount             decimal(20,6) not null comment '折扣费用',
   return_amt           decimal(20,6) comment '退款金额',
   return_date          datetime comment '退款日期',
   memo                 varchar(400) comment '备注',
   message              varchar(300) comment '买家留言',
   order_status         bigint(20) not null comment '订单状态（普通订单：待付款，已取消[用户未付款时直接取消]，待接单，待服务，待退款[用户申请退款，待接单与待服务状态都可以申请退款]，已关闭[已经退款给用户，订单关闭],[客户付尾款，商户确认服务完成]交易完成，待评价[交易完成可评价])   定制订单：待确定[用户提交购买申请]，待付款，已取消[用户未付款时直接取消]，待接单，待服务，待退款[用户申请退款，待接单与待服务状态都可以申请退款]，[客户付尾款，商户确认服务完成]交易完成，待评价[交易完成可评价]）',
   delivery_status      bigint(20) not null comment '配送状态',
   pay_status           bigint(20) not null comment '支付状态',
   consignee            varchar(30) not null comment '收货人',
   country_id           bigint(20) comment '国家',
   province_id          bigint(20) comment '省份',
   city_id              bigint(20) comment '城市',
   district_id          bigint(20) comment '区域街道',
   mobile               varchar(20) not null comment '联系手机号码',
   detail_address       varchar(255) comment '详细地址',
   invoice_type         bigint(20) comment '发票类型（电子发票，纸质发票)',
   invoice_header       varchar(60) comment '发票抬头名称',
   service_date         datetime comment '服务时间(婚礼)',
   budget_amount        decimal(20,6) comment '婚礼预算',
   related_service      varchar(60) comment '需要人员（多选）（婚礼策划师，摄影师，摄像师，化妆师，主持人）',
   service_style        varchar(60) comment '婚礼样式（多选）（浪漫，简约）',
   related_case_id      bigint(20) comment '关联案例编号',
   primary key (id)
);

alter table t_so_sheet comment '订单信息表';

/*==============================================================*/
/* Index: Index_so_code                                         */
/*==============================================================*/
create unique index Index_so_code on t_so_sheet
(
   code
);

/*==============================================================*/
/* Table: t_so_sheet_coupon                                     */
/*==============================================================*/
create table t_so_sheet_coupon
(
   id                   bigint(20) not null auto_increment comment '主键',
   order_id             bigint(20) not null comment '订单编号',
   coupon_id            bigint(20) not null comment '红包编号',
   primary key (id)
);

alter table t_so_sheet_coupon comment '订单使用优惠券情况';

/*==============================================================*/
/* Table: t_so_sheet_detail                                     */
/*==============================================================*/
create table t_so_sheet_detail
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   order_id             bigint(20) not null comment '关联订单编号',
   product_id           bigint(20) not null comment '关联产品编号',
   quantity             int not null comment '购买数量',
   price                decimal(20,6) not null comment '单价',
   amount               decimal(20,6) not null comment '金额',
   package_id           bigint(20) comment '套餐编号',
   primary key (id)
);

alter table t_so_sheet_detail comment '订单明细表';

/*==============================================================*/
/* Table: t_so_sheet_pay_info                                   */
/*==============================================================*/
create table t_so_sheet_pay_info
(
   id                   bigint(20) not null auto_increment comment '主键',
   order_id             bigint(20) not null comment '关联订单编号',
   pay_amt              decimal(20,6) not null comment '付款金额',
   pay_date             datetime not null comment '付款日期',
   primary key (id)
);

alter table t_so_sheet_pay_info comment '订单付款记录（分期付款时需要）';

/*==============================================================*/
/* Table: t_sys_ad_info                                         */
/*==============================================================*/
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

alter table t_sys_ad_info comment 'APP首页主广告栏';

/*==============================================================*/
/* Table: t_sys_app_info                                        */
/*==============================================================*/
create table t_sys_app_info
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   name                 varchar(60) not null comment '产品名称（1:XX-andorid版 2:XX-ios版）',
   code                 varchar(20) comment 'app编码，便于根据code查找',
   description          varchar(400) comment '产品描述',
   release_id           bigint(20) comment '关联最新发布编号',
   primary key (id)
);

alter table t_sys_app_info comment '应用信息';

/*==============================================================*/
/* Table: t_sys_app_release                                     */
/*==============================================================*/
create table t_sys_app_release
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   name                 varchar(60) not null comment '版本名称(1.1.1，字符串型)、',
   ver_no               bigint(20) not null comment '版本编号(1.0，数字型用来与app进行版本比较)',
   upgrade_desc         varchar(600) comment '版本升级描述',
   force_upgrade        bigint(20) not null comment '是否必须升级(1:是；0:否）',
   issue_date           datetime comment '发布日期',
   issue_user_id        bigint(20) comment '发布人',
   app_path             varchar(200) not null comment '应用下载地址',
   app_info_id          bigint(20) not null comment 'app信息：1:XX-andorid版 2:XX-ios版',
   primary key (id)
);

alter table t_sys_app_release comment '应用发布信息表';

/*==============================================================*/
/* Table: t_sys_article                                         */
/*==============================================================*/
create table t_sys_article
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   type_id              bigint(20) comment '文章分类（以后再建表）',
   title                varchar(60) not null comment '标题',
   code                 varchar(30) comment '特殊标识（比如注册协议可以增加一个特殊标识register_agreement）',
   issue_date           datetime not null comment '发布日期',
   content              text comment '内容',
   issue_user_id        bigint(20) comment '发布人',
   is_show              bigint(20) not null comment '是否显示（1：是，0：否）',
   is_sys_flag          bigint(20) not null comment '是否为系统内置文章（此类文章不可以删除，如商家协议等）',
   primary key (id)
);

alter table t_sys_article comment '文章信息';

/*==============================================================*/
/* Table: t_sys_article_type                                    */
/*==============================================================*/
create table t_sys_article_type
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   name                 varchar(60) not null comment '文章分类名称',
   parent_id            bigint(20) comment '父编号',
   is_show              bigint(20) not null comment '是否显示',
   seq_id               int comment '序号',
   primary key (id)
);

alter table t_sys_article_type comment '文章分类';

/*==============================================================*/
/* Table: t_sys_audit_log                                       */
/*==============================================================*/
create table t_sys_audit_log
(
   id                   bigint(20) not null auto_increment comment '主键',
   ref_id               bigint(20) not null comment '关联编号',
   audit_type           bigint(20) not null comment '审批类型：会员信息审核，博客审核，案例审核，商户基础信息，商户店铺（经营信息）',
   audit_operate        bigint(20) not null comment '审核动作：审核通过，审核不通过',
   audit_user_id        bigint(20) not null comment '审核人',
   audit_date           datetime not null comment '审核日期',
   audit_memo           varchar(200) comment '审核意见（不通过时必须填写）',
   primary key (id)
);

alter table t_sys_audit_log comment '审批日志';

/*==============================================================*/
/* Table: t_sys_config                                          */
/*==============================================================*/
create table t_sys_config
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   code                 varchar(30) not null comment '唯一编码',
   value                varchar(60) not null comment '值',
   description          varchar(200) comment '描述',
   primary key (id)
);

alter table t_sys_config comment '系统配置表';

/*==============================================================*/
/* Table: t_sys_config_detail                                   */
/*==============================================================*/
create table t_sys_config_detail
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   config_id            bigint(20) not null comment '关联配置编号',
   value                varchar(60) not null comment '值',
   description          varchar(200) comment '描述',
   primary key (id)
);

alter table t_sys_config_detail comment '系统配置明细，有多个值时适用';

/*==============================================================*/
/* Table: t_sys_feedback                                        */
/*==============================================================*/
create table t_sys_feedback
(
   id                   bigint(20) not null auto_increment comment '主键',
   vip_id               bigint(20) not null comment '会员编号',
   feedback_date        datetime not null comment '反馈时间',
   feedback_type        bigint(20) not null comment '反馈类型',
   content              varchar(500) not null comment '反馈内容',
   primary key (id)
);

alter table t_sys_feedback comment '会员反馈信息表';

/*==============================================================*/
/* Table: t_sys_module                                          */
/*==============================================================*/
create table t_sys_module
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   code                 varchar(30) not null comment '模块唯一编码',
   name                 varchar(60) not null comment '模块名称',
   parent_id            bigint(20) comment '关联上级模块主键编号',
   url                  varchar(200) comment '模块URL地址',
   module               varchar(30) comment '模块编号',
   controller           varchar(30) comment '模块对应的控制器编号',
   action               varchar(30) comment '对应操作',
   menu_flag            bigint(20) not null comment '是否菜单项',
   status               bigint(20) not null comment '是否有效？1：是；0：否',
   primary key (id)
);

alter table t_sys_module comment '模块信息表';

/*==============================================================*/
/* Index: Index_module_code                                     */
/*==============================================================*/
create unique index Index_module_code on t_sys_module
(
   code
);

/*==============================================================*/
/* Table: t_sys_notify                                          */
/*==============================================================*/
create table t_sys_notify
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   notify_type          bigint(20) comment '公告类型：店铺公告，平台公告',
   title                varchar(60) not null comment '标题',
   issue_date           datetime not null comment '发布日期',
   content              text comment '内容',
   vip_id               bigint(20) comment '关联商户编号(联商户布公告时使用此字段)',
   issue_user_id        bigint(20) comment '发布人（发布公告时使用此字段）',
   send_extend          bigint(20) not null comment '发送范围[全部（商户+会员)-待定,商户,会员]',
   status               bigint(20) not null comment '是否有效（1：是，0：否）',
   is_sent              bigint(20) not null comment '是否已发送（1：是，0：否）',
   sent_time            datetime comment '发送时间',
   primary key (id)
);

alter table t_sys_notify comment '系统消息';

/*==============================================================*/
/* Table: t_sys_notify_log                                      */
/*==============================================================*/
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

/*==============================================================*/
/* Table: t_sys_operation                                       */
/*==============================================================*/
create table t_sys_operation
(
   id                   bigint(20) not null auto_increment,
   code                 varchar(30) not null comment '操作唯一编码',
   name                 varchar(60) not null comment '操作名称',
   primary key (id)
);

alter table t_sys_operation comment '操作类型表';

/*==============================================================*/
/* Index: Index_op_code                                         */
/*==============================================================*/
create unique index Index_op_code on t_sys_operation
(
   code
);

/*==============================================================*/
/* Table: t_sys_operation_log                                   */
/*==============================================================*/
create table t_sys_operation_log
(
   id                   bigint(20) not null auto_increment comment '主键',
   user_id              bigint(20) not null comment '关联用户编号',
   module_id            bigint(20) comment '关联模块编号',
   op_date              datetime not null comment '操作日期',
   op_ip_addr           varchar(30) comment '操作IP地址',
   op_browser_type      varchar(200) comment '浏览器类型',
   op_url               varchar(400) comment '操作对应完整URL',
   op_desc              text comment '操作描述',
   op_method            varchar(20) comment '数据提交方式（POST,GET）',
   op_referrer          varchar(400) comment '访问地址来源',
   op_module            varchar(30) comment '模块',
   op_controller        varchar(30) comment '控制器',
   op_action            varchar(20) comment '操作',
   primary key (id)
);

alter table t_sys_operation_log comment '后台系统操作日志';

/*==============================================================*/
/* Table: t_sys_parameter                                       */
/*==============================================================*/
create table t_sys_parameter
(
   id                   bigint(20) not null comment '主键编号',
   type_id              bigint(20) not null comment '所属参数类型编号',
   param_val            varchar(60) not null comment '参数值',
   description          varchar(200) comment '描述',
   seq_id               bigint(20) comment '序号，用来显示的时候排序用',
   primary key (id)
);

alter table t_sys_parameter comment '参数表';

/*==============================================================*/
/* Table: t_sys_parameter_type                                  */
/*==============================================================*/
create table t_sys_parameter_type
(
   id                   bigint(20) not null comment '主键编号',
   name                 varchar(60) not null comment '类型名称',
   description          varchar(100) comment '描述',
   primary key (id)
);

alter table t_sys_parameter_type comment '参数类型表';

/*==============================================================*/
/* Table: t_sys_region                                          */
/*==============================================================*/
create table t_sys_region
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   name                 varchar(60) not null comment '区域名称',
   parent_id            bigint(20) comment '上级区域',
   region_type          bigint(20) not null comment '国家省市区类别',
   primary key (id)
);

alter table t_sys_region comment '区域信息';

/*==============================================================*/
/* Table: t_sys_relative_module                                 */
/*==============================================================*/
create table t_sys_relative_module
(
   id                   bigint(20) not null auto_increment comment '主键',
   name                 varchar(255) not null comment '版式名称',
   is_show              bigint(20) not null comment '是否显示',
   footer_content       text comment '底部内容',
   header_content       text comment '底部内容',
   vip_id               bigint(20) not null comment '关联商户编号',
   primary key (id)
);

alter table t_sys_relative_module comment '产品详情页关联版式';

/*==============================================================*/
/* Table: t_sys_role                                            */
/*==============================================================*/
create table t_sys_role
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   name                 varchar(60) not null comment '角色名称',
   description          varchar(200) comment '描述',
   primary key (id)
);

alter table t_sys_role comment '角色信息表';

/*==============================================================*/
/* Table: t_sys_role_rights                                     */
/*==============================================================*/
create table t_sys_role_rights
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   role_id              bigint(20) not null comment '关联角色编号',
   module_id            bigint(20) not null comment '关联模块编号',
   primary key (id)
);

alter table t_sys_role_rights comment '角色权限表';

/*==============================================================*/
/* Table: t_sys_role_user                                       */
/*==============================================================*/
create table t_sys_role_user
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   role_id              bigint(20) not null comment '关联角色编号',
   user_id              bigint(20) not null comment '用户编号',
   primary key (id)
);

alter table t_sys_role_user comment '用户角色表';

/*==============================================================*/
/* Table: t_sys_user                                            */
/*==============================================================*/
create table t_sys_user
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   user_id              varchar(20) not null comment '用户名(登陆名）',
   user_name            varchar(60) comment '姓名',
   password             varchar(50) not null comment '密码',
   is_admin             bigint(20) not null comment '是否超级管理员',
   status               bigint(20) not null comment '是否有效？1：是；0：否',
   last_login_date      datetime comment '最后一次登陆时间',
   primary key (id)
);

alter table t_sys_user comment '管理用户信息表';

/*==============================================================*/
/* Index: Index_user_id                                         */
/*==============================================================*/
create unique index Index_user_id on t_sys_user
(
   user_id
);

/*==============================================================*/
/* Table: t_sys_verify_code                                     */
/*==============================================================*/
create table t_sys_verify_code
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   verify_type          bigint(20) not null comment '0、手机号码验证；1、邮箱验证',
   sent_time            datetime not null comment '发送时间',
   expiration_time      datetime comment '过期时间',
   verify_code          varchar(10) not null comment '验证码',
   content              varchar(200) comment '手机短信内容',
   verify_number        varchar(15) not null comment '手机号码,邮箱',
   usage_type           bigint(20) comment '验证码用途类型（注册、找回密码）',
   primary key (id)
);

alter table t_sys_verify_code comment '手机（邮箱）验证码';

/*==============================================================*/
/* Table: t_sys_warehouse                                       */
/*==============================================================*/
create table t_sys_warehouse
(
   id                   bigint(20) not null auto_increment comment '主键',
   name                 varchar(30) not null comment '仓库名称',
   vip_id               bigint(20) not null comment '关联商户编号',
   primary key (id)
);

alter table t_sys_warehouse comment '产品仓库';

/*==============================================================*/
/* Table: t_sys_warehouse_region                                */
/*==============================================================*/
create table t_sys_warehouse_region
(
   id                   bigint(20) not null auto_increment comment '主键',
   warehouse_id         bigint(20) not null comment '关联仓库编号',
   region_id            bigint(20) not null comment '关联所辖区域',
   primary key (id)
);

alter table t_sys_warehouse_region comment '仓库所辖区域';

/*==============================================================*/
/* Table: t_vip                                                 */
/*==============================================================*/
create table t_vip
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   vip_id               varchar(30) not null comment '会员登陆名',
   merchant_flag        bigint(20) not null comment '是否商户?1:是；0：否',
   vip_name             varchar(50) comment '姓名',
   last_login_date      datetime comment '最后一次登陆时间',
   password             varchar(50) not null comment '密码',
   parent_id            bigint(20) comment '上级会员编号',
   mobile               varchar(20) comment '手机号码',
   mobile_verify_flag   bigint(20) comment '手机号码是否已经验证',
   email                varchar(30) comment '安全邮箱',
   email_verify_flag    bigint(20) not null comment '安全邮箱是否已验证(1:是；0：否)',
   status               bigint(20) not null comment '是否有效(1:正常、0:停用)',
   register_date        datetime not null comment '注册时间',
   rank_id              bigint(20) comment '会员等级（关联和会员类型应该不需要会员等级）',
   audit_status         bigint(20) not null comment '审核状态(商户字段)：未审核，审核不通过，已审核',
   audit_user_id        bigint(20) comment '审核人',
   audit_date           datetime comment '审核日期',
   audit_memo           varchar(200) comment '审核意见（不通过时必须填写）',
   vip_type_id          bigint(20) comment '会员类型（婚礼人类型：策划师，主持人，摄影师，化妆师，摄像师）',
   sex                  bigint(20) comment '性别',
   nick_name            varchar(50) comment '会员昵称',
   wedding_date         datetime comment '婚期',
   birthday             datetime comment '生日',
   img_url              varchar(255) comment '用户图像-图片（放大后查看）',
   thumb_url            varchar(255) comment '用户图像-缩略图',
   img_original         varchar(255) comment '用户图像-原图',
   primary key (id)
);

alter table t_vip comment '会员信息';

/*==============================================================*/
/* Index: Index_vip_id                                          */
/*==============================================================*/
create unique index Index_vip_id on t_vip
(
   vip_id,
   merchant_flag
);

/*==============================================================*/
/* Table: t_vip_address                                         */
/*==============================================================*/
create table t_vip_address
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   vip_id               bigint(20) not null comment '会员编号',
   consignee            varchar(30) not null comment '收货人姓名',
   phone_number         varchar(20) not null comment '收货人手机号码',
   district_id          bigint(20) not null comment '镇，区域编号',
   city_id              bigint(20) not null comment '城市编号',
   province_id          bigint(20) not null comment '收货省份',
   county_id            bigint(20) not null comment '国家编号',
   detail_address       varchar(150) not null comment '收货详细地址',
   default_flag         bigint(20) not null comment '是否设置为默认收货地址(1：是；0：否)',
   primary key (id)
);

alter table t_vip_address comment '会员收货地址表';

/*==============================================================*/
/* Table: t_vip_blog                                            */
/*==============================================================*/
create table t_vip_blog
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   blog_type            bigint(20) comment '博客频道',
   blog_flag            bigint(20) not null comment '博客分类：会员博客，商户博客',
   vip_id               bigint(20) comment '关联会员编号',
   content              text not null comment '发布内容',
   create_date          datetime not null comment '发布时间',
   update_date          datetime not null comment '更新时间',
   audit_user_id        bigint(20) comment '审核人',
   audit_status         bigint(20) not null comment '审核状态（未审核，审核通过，审核不通过）',
   audit_date           datetime comment '审核日期',
   audit_memo           varchar(200) comment '审核意见（不通过时必须填写）',
   status               bigint(20) not null comment '是否显示？1：是；0：否',
   primary key (id)
);

alter table t_vip_blog comment '店铺博客';

/*==============================================================*/
/* Table: t_vip_blog_cmt                                        */
/*==============================================================*/
create table t_vip_blog_cmt
(
   id                   bigint(20) not null comment '主键',
   content              varchar(255) not null comment '回复内容',
   blog_id              bigint(20) not null comment '关联评价编号',
   reply_date           datetime not null comment '回复日期',
   vip_id               bigint(20) not null comment '关联用户编号',
   status               bigint(20) not null comment '是否显示?1:是：0:否',
   parent_id            bigint(20) comment '上级评论',
   primary key (id)
);

alter table t_vip_blog_cmt comment '博客评价';

/*==============================================================*/
/* Table: t_vip_blog_likes                                      */
/*==============================================================*/
create table t_vip_blog_likes
(
   id                   bigint(20) not null comment '主键',
   vip_id               bigint(20) not null comment '点赞会员',
   blog_id              bigint(20) comment '关联博客',
   blog_cmt_id          bigint(20) comment '关联博客评论',
   create_date          datetime not null comment '点赞日期',
   primary key (id)
);

alter table t_vip_blog_likes comment '博客点赞';

/*==============================================================*/
/* Table: t_vip_blog_photo                                      */
/*==============================================================*/
create table t_vip_blog_photo
(
   id                   bigint(20) not null auto_increment comment '主键',
   blog_id              bigint(20) not null comment '关联博客编号',
   img_url              varchar(255) not null comment '图片（放大后查看）',
   thumb_url            varchar(255) not null comment '缩略图',
   img_original         varchar(255) not null comment '原始图片',
   primary key (id)
);

alter table t_vip_blog_photo comment '博客图片';

/*==============================================================*/
/* Table: t_vip_blog_type                                       */
/*==============================================================*/
create table t_vip_blog_type
(
   id                   bigint(20) not null auto_increment comment '主键',
   name                 varchar(50) not null comment '名字',
   parent_id            bigint(20) comment '上级频道分类',
   primary key (id)
);

alter table t_vip_blog_type comment '博客频道';

/*==============================================================*/
/* Table: t_vip_case                                            */
/*==============================================================*/
create table t_vip_case
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   name                 varchar(50) not null comment '案例名称',
   type_id              bigint(20) not null comment '案例类型',
   vip_id               bigint(20) not null comment '关联商户编号',
   content              text not null comment '发布内容',
   create_date          datetime not null comment '发布时间',
   update_date          datetime not null comment '更新时间',
   status               bigint(20) not null comment '是否显示？1：是；0：否',
   audit_status         bigint(20) not null comment '审核状态：未审核，审核不通过，已审核',
   audit_user_id        bigint(20) comment '审核人',
   audit_date           datetime comment '审核日期',
   audit_memo           varchar(200) comment '审核意见（不通过时必须填写）',
   cover_img_url        varchar(255) not null comment '图片（放大后查看）(封面)',
   cover_thumb_url      varchar(255) not null comment '缩略图(封面)',
   cover_img_original   varchar(255) not null comment '原图(封面)',
   is_hot               bigint(20) not null comment '是否经典案例（经典案例显示在首页）',
   case_flag            bigint(20) not null comment '案例类别？个人案例，团体案例（团体案例可以通过订单来生成，也可以手动创建）',
   market_price         decimal(20,6) comment '市场价',
   sale_price           decimal(20,6) comment '销售价',
   primary key (id)
);

alter table t_vip_case comment '店铺案例';

/*==============================================================*/
/* Table: t_vip_case_detail                                     */
/*==============================================================*/
create table t_vip_case_detail
(
   id                   bigint(20) not null auto_increment comment '主键',
   case_id              bigint(20) not null comment '关联案例编号',
   product_id           bigint(20) not null comment '产品编号',
   primary key (id)
);

alter table t_vip_case_detail comment '案例明细';

/*==============================================================*/
/* Table: t_vip_case_photo                                      */
/*==============================================================*/
create table t_vip_case_photo
(
   id                   bigint(20) not null auto_increment comment '主键',
   case_id              bigint(20) not null comment '关联案例编号',
   img_url              varchar(255) not null comment '图片（放大后查看）',
   thumb_url            varchar(255) not null comment '缩略图',
   img_original         varchar(255) not null comment '原始图片',
   primary key (id)
);

alter table t_vip_case_photo comment '店铺案例图片';

/*==============================================================*/
/* Table: t_vip_case_type                                       */
/*==============================================================*/
create table t_vip_case_type
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   name                 varchar(40) not null comment '案例类型名称',
   vip_type_id          bigint(20) comment '会员类型(商家类型）',
   primary key (id)
);

alter table t_vip_case_type comment '案例类型';

/*==============================================================*/
/* Table: t_vip_case_type_prop                                  */
/*==============================================================*/
create table t_vip_case_type_prop
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   case_type_id         bigint(20) not null comment '案例类别编号',
   prop_name            varchar(60) not null comment '属性名称',
   is_required          bigint(20) not null comment '是否必填项？1：是；0：否',
   input_type           bigint(20) comment '录入类型：输入，从列表中选取，日期选择（可暂时不做）',
   multi_select         bigint(20) not null comment '是否可以多选？1：是，0：否',
   primary key (id)
);

alter table t_vip_case_type_prop comment '案例分类属性';

/*==============================================================*/
/* Table: t_vip_case_type_prop_val                              */
/*==============================================================*/
create table t_vip_case_type_prop_val
(
   id                   bigint(20) not null comment '主键',
   prop_id              bigint(20) not null comment '对应属性编号',
   prop_value           varchar(50) not null comment '对应属性值',
   primary key (id)
);

alter table t_vip_case_type_prop_val comment '案例属性值（主要针对销售属性，销售属性为单选属性）';

/*==============================================================*/
/* Table: t_vip_collect                                         */
/*==============================================================*/
create table t_vip_collect
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   vip_id               bigint(20) not null comment '会员编号',
   product_id           bigint(20) comment '关联产品',
   package_id           bigint(20) comment '关联套餐',
   case_id              bigint(20) comment '关联案例',
   blog_id              bigint(20) comment '关联话题',
   collect_date         datetime not null comment '收藏时间',
   primary key (id)
);

alter table t_vip_collect comment '会员收藏';

/*==============================================================*/
/* Table: t_vip_concern                                         */
/*==============================================================*/
create table t_vip_concern
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   vip_id               bigint(20) not null comment '会员编号',
   ref_vip_id           bigint(20) not null comment '关注会员编号',
   concern_date         datetime not null comment '关注时间',
   primary key (id)
);

alter table t_vip_concern comment '会员关注';

/*==============================================================*/
/* Table: t_vip_coupon                                          */
/*==============================================================*/
create table t_vip_coupon
(
   id                   bigint(20) not null auto_increment comment '主键',
   coupon_type_id       bigint(20) not null comment '优惠券类型',
   vip_id               bigint(20) not null comment '所属会员',
   coupon_sn            varchar(20) not null comment '优惠券编号',
   used_time            datetime comment '使用时间',
   used_amount          decimal(20,6) not null comment '已使用金额',
   order_id             bigint(20) comment '关联订单编号',
   primary key (id)
);

alter table t_vip_coupon comment '优惠券';

/*==============================================================*/
/* Table: t_vip_coupon_log                                      */
/*==============================================================*/
create table t_vip_coupon_log
(
   id                   bigint(20) not null auto_increment comment '主键',
   coupon_id            bigint(20) not null comment '关联优惠券编号',
   order_id             bigint(20) not null comment '使用订单',
   used_amount          decimal(20,6) not null comment '使用金额，退还金额',
   use_time             datetime not null comment '发生时间',
   use_desc             varchar(255) not null comment '发生描述',
   primary key (id)
);

alter table t_vip_coupon_log comment '优惠券使用记录';

/*==============================================================*/
/* Table: t_vip_coupon_type                                     */
/*==============================================================*/
create table t_vip_coupon_type
(
   id                   bigint(20) not null auto_increment comment '主键',
   name                 varchar(50) not null comment '优惠券名称',
   type_money           decimal(20,6) comment '优惠券金额',
   send_type            bigint(20) comment '优惠券发送方式（按用户发放，按商品发放，按订单金额发放，线下发放的红包，注册送红包）',
   min_amount           decimal(20,6) comment '最小订单金额（只有商品总金额达到这个数的订单才能使用这种优惠券）',
   max_amount           decimal(20,6) comment '订单下限（只要订单金额达到该数值，就会发放红包给用户） - 针对按订单发放',
   send_start_date      datetime comment '发放起始日期(只有当前时间介于起始日期和截止日期之间时，此类型的红包才可以发放) - 只针对按商品发放,按订单金额发放,注册送红包',
   send_end_date        datetime comment '发放结束日期',
   use_start_date       datetime comment '使用起始日期（只有当前时间介于起始日期和截止日期之间时，此类型的红包才可以使用）',
   use_end_date         datetime comment '使用结束日期',
   vip_id               bigint(20) not null comment '关联商户编号',
   primary key (id)
);

alter table t_vip_coupon_type comment '优惠券类型';

/*==============================================================*/
/* Table: t_vip_extend                                          */
/*==============================================================*/
create table t_vip_extend
(
   id                   bigint(20) not null auto_increment comment '主键',
   vip_id               bigint(20) not null comment '关联会员编号',
   real_name            varchar(50) comment '真实姓名',
   id_card_no           varchar(30) comment '身份证号码',
   id_card_img_url      varchar(255) comment '身份证正面照-图片（放大后查看）',
   id_card_thumb_url    varchar(255) comment '身份证正面照-缩略图',
   id_card_img_original varchar(255) comment '身份证正面照-原图',
   id_back_img_url      varchar(255) comment '身份证背面照-图片（放大后查看）',
   id_back_thumb_url    varchar(255) comment '身份证背面照-缩略图',
   id_back_img_original varchar(255) comment '身份证背面照-原图',
   bl_img_url           varchar(255) comment '公司营业执照-图片（放大后查看）',
   bl_thumb_url         varchar(255) comment '公司营业执照-缩略图',
   bl_img_original      varchar(255) comment '公司营业执照-原图',
   bank_account         varchar(30) comment '银行账户（真实姓名）',
   bank_name            varchar(50) comment '开户银行',
   bank_number          varchar(50) comment '银行卡号',
   bank_addr            varchar(255) comment '开户支行（如，招商银行深圳分行科技园支行）',
   audit_status         bigint(20) not null comment '审核状态：未审核，审核不通过，已审核',
   audit_user_id        bigint(20) comment '审核人',
   audit_date           datetime comment '审核日期',
   audit_memo           varchar(200) comment '审核意见（不通过时必须填写）',
   create_date          datetime not null comment '创建时间',
   update_date          datetime not null comment '更新时间',
   primary key (id)
);

alter table t_vip_extend comment '会员认证信息（扩展信息）（需要审核）';

/*==============================================================*/
/* Table: t_vip_module                                          */
/*==============================================================*/
create table t_vip_module
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   code                 varchar(30) not null comment '模块唯一编码',
   name                 varchar(60) not null comment '模块名称',
   parent_id            bigint(20) comment '关联上级模块主键编号',
   url                  varchar(200) comment '模块URL地址',
   module               varchar(30) comment '对应模块',
   controller           varchar(30) not null comment '模块对应的控制器编号',
   action               varchar(30) not null comment '对应操作',
   menu_flag            bigint(20) not null comment '是否菜单项',
   status               bigint(20) not null comment '是否有效？1：是；0：否',
   merchant_flag        bigint(20) not null comment '是否商户操作模块（1：商户；0：会员）',
   primary key (id)
);

alter table t_vip_module comment '会员/商户操作模块';

/*==============================================================*/
/* Index: idx_vip_module_code                                   */
/*==============================================================*/
create unique index idx_vip_module_code on t_vip_module
(
   code
);

/*==============================================================*/
/* Table: t_vip_operation_log                                   */
/*==============================================================*/
create table t_vip_operation_log
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   vip_id               bigint(20) comment '会员编号',
   module_id            bigint(20) comment '关联模块编号',
   op_date              datetime not null comment '操作日期',
   op_ip_addr           varchar(30) comment '操作IP地址',
   op_browser_type      varchar(300) comment '浏览器类型',
   op_phone_model       varchar(60) comment '手机型号',
   op_url               varchar(1000) comment '操作对应完整URL',
   op_desc              text comment '操作描述',
   op_os_type           varchar(100) comment '操作系统',
   op_method            varchar(20) comment '数据提交方式（POST,GET）',
   op_app_ver           varchar(20) comment 'app版本号',
   op_app_type_id       bigint(20) comment 'app类型：1:andorid 2:ios',
   op_module            varchar(30) comment '模块',
   op_controller        varchar(30) comment '控制器',
   op_action            varchar(20) comment '操作',
   op_referrer          varchar(400) comment '访问地址来源',
   primary key (id)
);

alter table t_vip_operation_log comment '会员操作日志表';

/*==============================================================*/
/* Table: t_vip_org_gallery                                     */
/*==============================================================*/
create table t_vip_org_gallery
(
   id                   bigint(20) not null auto_increment comment '主键编号',
   organization_id      bigint(20) not null comment '关联店铺编号',
   img_url              varchar(255) not null comment '图片（放大后查看）',
   thumb_url            varchar(255) not null comment '缩略图',
   img_original         varchar(255) not null comment '原图',
   sequence_id          bigint(20) not null comment '显示顺序',
   redirect_url         varchar(255) comment '点击后跳转关联URL',
   primary key (id)
);

alter table t_vip_org_gallery comment '店铺相册(暂时作为封面）';

/*==============================================================*/
/* Table: t_vip_organization                                    */
/*==============================================================*/
create table t_vip_organization
(
   id                   bigint(20) not null auto_increment comment '主键',
   name                 varchar(30) comment '门店（店铺、机构）名称',
   status               bigint(20) not null comment '状态（1：有效；0：无效）',
   logo_img_url         varchar(255) comment '图片（放大后查看）（logo）',
   logo_thumb_url       varchar(255) comment '缩略图（logo）',
   logo_img_original    varchar(255) comment '原始图片（logo）',
   cover_img_url        varchar(255) comment '图片（放大后查看）(封面)',
   cover_thumb_url      varchar(255) comment '缩略图(封面)',
   cover_img_original   varchar(255) comment '原图(封面)',
   vip_id               bigint(20) not null comment '所属会员',
   description          varchar(500) comment '店铺简介',
   country_id           bigint(20) comment '关联国家编号',
   province_id          bigint(20) comment '关联省份编号',
   city_id              bigint(20) comment '关联城市编号',
   audit_status         bigint(20) not null comment '审核状态：未审核，审核不通过，已审核',
   audit_user_id        bigint(20) comment '审核人',
   audit_date           datetime comment '审核日期',
   audit_memo           varchar(200) comment '审核意见（不通过时必须填写）',
   create_date          datetime not null comment '创建时间',
   update_date          datetime not null comment '更新时间',
   primary key (id)
);

alter table t_vip_organization comment '企业信息（门店信息）';

/*==============================================================*/
/* Table: t_vip_product_type                                    */
/*==============================================================*/
create table t_vip_product_type
(
   id                   bigint(20) not null auto_increment comment '主键',
   product_type_id      bigint(20) not null comment '关联产品分类',
   vip_type_id          bigint(20) not null comment '关联商家类别',
   vip_id               bigint(20) comment '关联会员编号（用于会员直接关联商品分类，待用）',
   primary key (id)
);

alter table t_vip_product_type comment '会员（商家）经营商品范围';

/*==============================================================*/
/* Table: t_vip_rank                                            */
/*==============================================================*/
create table t_vip_rank
(
   id                   bigint(20) not null auto_increment comment '主键',
   name                 varchar(30) not null comment '会员等级名称',
   min_points           int(10) not null comment '最少等级积分',
   max_points           int(10) not null comment '最大等级积分',
   discount             decimal(20,6) comment '折扣',
   primary key (id)
);

alter table t_vip_rank comment '会员等级';

/*==============================================================*/
/* Table: t_vip_type                                            */
/*==============================================================*/
create table t_vip_type
(
   id                   bigint(20) not null auto_increment comment '主键',
   code                 varchar(30) comment '编号',
   name                 varchar(60) not null comment '名称',
   description          varchar(400) comment '描述',
   seq_id               int comment '排序',
   merchant_flag        bigint(20) not null comment '是否商家类型？1：商家；0：会员',
   primary key (id)
);

alter table t_vip_type comment '会员类型';

alter table t_act_buy_discount add constraint fk_buy_discount_double_ref_param foreign key (is_double)
      references t_sys_parameter (id);

alter table t_act_buy_discount add constraint fk_buy_discount_ref_act foreign key (act_id)
      references t_activity (id);

alter table t_act_buy_giving_detail add constraint fk_buy_give_double_ref_param foreign key (is_double_give)
      references t_sys_parameter (id);

alter table t_act_buy_giving_detail add constraint fk_buy_giving_ref_act foreign key (act_id)
      references t_activity (id);

alter table t_act_buy_giving_detail add constraint fk_giving_prod_ref_prod foreign key (giving_product_id)
      references t_product (id);

alter table t_act_buy_giving_detail_pkg add constraint fk_giving_package_ref_detail foreign key (buy_giving_detail_id)
      references t_act_buy_giving_detail (id);

alter table t_act_buy_giving_detail_pkg add constraint fk_giving_pkg_ref_prod foreign key (giving_product_id)
      references t_product (id);

alter table t_act_exchange_product add constraint fk_exchange_prod_ref_param foreign key (is_exchange)
      references t_sys_parameter (id);

alter table t_act_exchange_product add constraint fk_exchange_prod_ref_prod foreign key (product_id)
      references t_product (id);

alter table t_act_package_product add constraint fk_package_goods_ref_act foreign key (act_id)
      references t_activity (id);

alter table t_act_package_product add constraint fk_package_prod_ref_product foreign key (product_id)
      references t_product (id);

alter table t_act_package_product add constraint fk_pkg_prod_ref_prod foreign key (product_id)
      references t_product (id);

alter table t_act_scope add constraint fk_act_brand_ref_act foreign key (act_id)
      references t_activity (id);

alter table t_act_scope add constraint fk_act_brand_ref_brand foreign key (brand_id)
      references t_product_brand (id);

alter table t_act_scope add constraint fk_act_scope_ref_product foreign key (product_id)
      references t_product (id);

alter table t_act_scope add constraint fk_act_scope_ref_product_type foreign key (product_type_id)
      references t_product_type (id);

alter table t_act_special_price add constraint fk_spec_price_ref_prod foreign key (product_id)
      references t_product (id);

alter table t_act_special_price add constraint fk_special_price_ref_act foreign key (act_id)
      references t_activity (id);

alter table t_activity add constraint fk_act_scope_ref_param foreign key (activity_scope)
      references t_sys_parameter (id);

alter table t_activity add constraint fk_act_type_ref_param foreign key (activity_type)
      references t_sys_parameter (id);

alter table t_activity add constraint fk_activity_vip_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_delivery_type add constraint fk_delivery_ref_tpl foreign key (tpl_id)
      references t_delivery_type_tpl (id);

alter table t_delivery_type add constraint fk_delivery_type_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_delivery_type add constraint fk_delivery_type_vip_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_delivery_type_area add constraint fk_delivery_area_ref_delivery foreign key (delivery_id)
      references t_delivery_type (id);

alter table t_delivery_type_area_region add constraint fk_delivery_region_ref_area foreign key (delivery_area_id)
      references t_delivery_type_area (id);

alter table t_delivery_type_area_region add constraint fk_delivery_region_ref_region foreign key (region_id)
      references t_sys_region (id);

alter table t_delivery_type_tpl add constraint fk_deliv_type_tpl_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_out_stock_sheet add constraint fk_out_ref_delivery_type foreign key (delivery_type)
      references t_delivery_type (id);

alter table t_out_stock_sheet add constraint fk_out_stock_ref_so foreign key (order_id)
      references t_so_sheet (id);

alter table t_out_stock_sheet add constraint fk_out_stock_sheet_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_out_stock_sheet add constraint fk_out_stock_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_out_stock_sheet add constraint fk_out_stock_user_ref_user foreign key (user_id)
      references t_sys_user (id);

alter table t_out_stock_sheet_detail add constraint fk_out_detail_ref_prod foreign key (product_id)
      references t_product (id);

alter table t_out_stock_sheet_detail add constraint fk_out_stock_det_ref_out foreign key (out_stock_id)
      references t_out_stock_sheet (id);

alter table t_pay_type add constraint fk_pay_type_cod_ref_param foreign key (is_cod)
      references t_sys_parameter (id);

alter table t_pay_type add constraint fk_pay_type_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_pick_up_point add constraint fk_pick_up_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_pick_up_point add constraint fk_pick_up_vip_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_pick_up_point_region add constraint fk_pickup_region_ref_pickup foreign key (point_id)
      references t_pick_up_point (id);

alter table t_pick_up_point_region add constraint fk_pickup_region_ref_region foreign key (region_id)
      references t_sys_region (id);

alter table t_product add constraint fk_p_group_ref_product foreign key (product_group_id)
      references t_product_group (id);

alter table t_product add constraint fk_p_type_ref_product foreign key (type_id)
      references t_product_type (id);

alter table t_product add constraint fk_prod_is_hot_ref_param foreign key (is_hot)
      references t_sys_parameter (id);

alter table t_product add constraint fk_product_audit_stat_ref_param foreign key (audit_status)
      references t_sys_parameter (id);

alter table t_product add constraint fk_product_audit_usr_ref_user foreign key (audit_user_id)
      references t_sys_user (id);

alter table t_product add constraint fk_product_can_return_ref_param foreign key (can_return_flag)
      references t_sys_parameter (id);

alter table t_product add constraint fk_product_free_ship_ref_param foreign key (is_free_shipping)
      references t_sys_parameter (id);

alter table t_product add constraint fk_product_on_sale_ref_param foreign key (is_on_sale)
      references t_sys_parameter (id);

alter table t_product add constraint fk_product_ref_brand foreign key (brand_id)
      references t_product_brand (id);

alter table t_product add constraint fk_product_ref_rel_module foreign key (relative_module)
      references t_sys_relative_module (id);

alter table t_product add constraint fk_product_vip_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_product_comment add constraint fk_fk_p_comment_result_ref_param foreign key (cmt_rank_id)
      references t_sys_parameter (id);

alter table t_product_comment add constraint fk_p_comment_ref_product foreign key (product_id)
      references t_product (id);

alter table t_product_comment add constraint fk_prod_cmt_parent_ref_prod foreign key (parent_id)
      references t_product_comment (id);

alter table t_product_comment add constraint fk_prod_cmt_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_product_comment add constraint fk_product_cmt_show_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_product_comment_photo add constraint fk_prod_cmt_photo_ref_cmt foreign key (comment_id)
      references t_product_comment (id);

alter table t_product_comment_reply add constraint fk_cmt_reply_ref_cmt foreign key (comment_id)
      references t_product_comment (id);

alter table t_product_comment_reply add constraint fk_cmt_reply_user_ref_cmt foreign key (user_id)
      references t_sys_user (id);

alter table t_product_gallery add constraint fk_prod_gallery_pri_ref_param foreign key (primary_flag)
      references t_sys_parameter (id);

alter table t_product_gallery add constraint fk_product_photo_ref_product foreign key (product_id)
      references t_product (id);

alter table t_product_home_ads add constraint fk_product_ads_ref_product foreign key (product_id)
      references t_product (id);

alter table t_product_prod_sale add constraint fk_prod_attr_ref_product foreign key (product_id)
      references t_product (id);

alter table t_product_prod_sale_prop add constraint fk_mat_prod_prop_ref_prod foreign key (attr_group_id)
      references t_product_prod_sale (id);

alter table t_product_prod_sale_prop add constraint fk_prod_attr_ref_prop foreign key (prop_id)
      references t_product_prop (id);

alter table t_product_prop add constraint fk_p_prop_ref_prop foreign key (prop_id)
      references t_product_type_prop (id);

alter table t_product_prop add constraint fk_p_prop_ref_prop_val foreign key (prop_val)
      references t_product_type_prop_val (id);

alter table t_product_prop add constraint fk_product_prop_ref_product foreign key (product_id)
      references t_product (id);

alter table t_product_stock add constraint fk_p_stock_ref_wh foreign key (warehouse_id)
      references t_sys_warehouse (id);

alter table t_product_stock add constraint fk_prod_stock_ref_prod foreign key (product_id)
      references t_product (id);

alter table t_product_type add constraint fk_ptype_parent_ref_ptype foreign key (parent_id)
      references t_product_type (id);

alter table t_product_type_prop add constraint fk_p_type_prop_input_tp_ref_param foreign key (input_type)
      references t_sys_parameter (id);

alter table t_product_type_prop add constraint fk_p_type_prop_multi_ref_param foreign key (multi_select)
      references t_sys_parameter (id);

alter table t_product_type_prop add constraint fk_p_type_prop_required_ref_param foreign key (is_required)
      references t_sys_parameter (id);

alter table t_product_type_prop add constraint fk_p_type_prop_sale_ref_param foreign key (is_sale_prop)
      references t_sys_parameter (id);

alter table t_product_type_prop add constraint fk_type_prop_ref_ptype foreign key (product_type_id)
      references t_product_type (id);

alter table t_product_type_prop_val add constraint fk_property_val_ref_prop foreign key (prop_id)
      references t_product_type_prop (id);

alter table t_product_vip_price add constraint fk_rank_price_ref_product foreign key (product_id)
      references t_product (id);

alter table t_product_vip_price add constraint fk_rank_price_ref_rank foreign key (vip_rank_id)
      references t_vip_rank (id);

alter table t_refund_sheet add constraint fk_refund_ref_order foreign key (order_id)
      references t_so_sheet (id);

alter table t_refund_sheet add constraint fk_refund_ref_return foreign key (return_id)
      references t_return_sheet (id);

alter table t_refund_sheet add constraint fk_refund_ref_rfd_apply foreign key (refund_apply_id)
      references t_refund_sheet_apply (id);

alter table t_refund_sheet add constraint fk_refund_ref_user foreign key (user_id)
      references t_sys_user (id);

alter table t_refund_sheet add constraint fk_refund_st_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_refund_sheet add constraint fk_refund_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_refund_sheet_apply add constraint fk_refund_apply_ref_so_sheet foreign key (order_id)
      references t_so_sheet (id);

alter table t_refund_sheet_apply add constraint fk_refund_apply_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_refund_sheet_apply add constraint fk_refund_apply_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_return_apply add constraint fk_return_apply_ref_order foreign key (order_id)
      references t_so_sheet (id);

alter table t_return_apply add constraint fk_return_apply_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_return_apply add constraint fk_return_apply_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_return_apply_detail add constraint fk_return_apply_dt_ref_prod foreign key (product_id)
      references t_product (id);

alter table t_return_apply_detail add constraint fk_rt_detail_ref_return foreign key (return_apply_id)
      references t_return_apply (id);

alter table t_return_sheet add constraint fk_return_ref_return_apply foreign key (return_apply_id)
      references t_return_apply (id);

alter table t_return_sheet add constraint fk_return_sheet_ref_out foreign key (out_id)
      references t_out_stock_sheet (id);

alter table t_return_sheet add constraint fk_return_sheet_ref_user foreign key (user_id)
      references t_sys_user (id);

alter table t_return_sheet add constraint fk_return_sheet_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_return_sheet add constraint fk_return_sheet_stat_ref_para foreign key (status)
      references t_sys_parameter (id);

alter table t_return_sheet add constraint fk_return_st_ref_so_st foreign key (order_id)
      references t_so_sheet (id);

alter table t_return_sheet_detail add constraint fk_return_detail_ref_product foreign key (product_id)
      references t_product (id);

alter table t_return_sheet_detail add constraint fk_return_detail_ref_return foreign key (return_id)
      references t_return_sheet (id);

alter table t_sheet_log add constraint fk_sheet_log_ref_user foreign key (user_id)
      references t_sys_user (id);

alter table t_sheet_log add constraint fk_sheet_log_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_shopping_cart add constraint fk_cart_ref_package foreign key (package_id)
      references t_activity (id);

alter table t_shopping_cart add constraint fk_cart_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_shopping_cart add constraint fk_shop_cart_ref_product foreign key (product_id)
      references t_product (id);

alter table t_shopping_cart add constraint fk_shopping_cart_parent_ref_cart foreign key (parent_id)
      references t_shopping_cart (id);

alter table t_shopping_cart add constraint fk_shpping_cart_checked_ref_param foreign key (is_checked)
      references t_sys_parameter (id);

alter table t_shopping_cart add constraint fk_shpping_cart_gift_ref_param foreign key (is_gift)
      references t_sys_parameter (id);

alter table t_so_sheet add constraint fk_so_city_ref_region foreign key (city_id)
      references t_sys_region (id);

alter table t_so_sheet add constraint fk_so_country_ref_region foreign key (country_id)
      references t_sys_region (id);

alter table t_so_sheet add constraint fk_so_delivery_stat_ref_param foreign key (delivery_status)
      references t_sys_parameter (id);

alter table t_so_sheet add constraint fk_so_district_ref_region foreign key (district_id)
      references t_sys_region (id);

alter table t_so_sheet add constraint fk_so_invoice_ref_param foreign key (invoice_type)
      references t_sys_parameter (id);

alter table t_so_sheet add constraint fk_so_order_stat_ref_param foreign key (order_status)
      references t_sys_parameter (id);

alter table t_so_sheet add constraint fk_so_pay_stat_ref_param foreign key (pay_status)
      references t_sys_parameter (id);

alter table t_so_sheet add constraint fk_so_province_ref_region foreign key (province_id)
      references t_sys_region (id);

alter table t_so_sheet add constraint fk_so_ref_delivery_type foreign key (delivery_type)
      references t_delivery_type (id);

alter table t_so_sheet add constraint fk_so_sheet_case_id_ref_org_case foreign key (related_case_id)
      references t_vip_case (id);

alter table t_so_sheet add constraint fk_so_sheet_ref_pay_type foreign key (pay_type_id)
      references t_pay_type (id);

alter table t_so_sheet add constraint fk_so_sheet_ref_pickup_point foreign key (pick_point_id)
      references t_pick_up_point (id);

alter table t_so_sheet add constraint fk_so_sheet_ref_st_type foreign key (sheet_type_id)
      references t_sheet_type (id);

alter table t_so_sheet add constraint fk_so_sheet_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_so_sheet_coupon add constraint fk_st_bonus_ref_sheet foreign key (order_id)
      references t_so_sheet (id);

alter table t_so_sheet_coupon add constraint fk_st_coupon_ref_coupon foreign key (coupon_id)
      references t_vip_coupon (id);

alter table t_so_sheet_detail add constraint fk_so_detail_ref_order foreign key (order_id)
      references t_so_sheet (id);

alter table t_so_sheet_detail add constraint fk_so_detail_ref_package foreign key (package_id)
      references t_activity (id);

alter table t_so_sheet_detail add constraint fk_so_detail_ref_prod foreign key (product_id)
      references t_product (id);

alter table t_so_sheet_pay_info add constraint fk_st_pay_ref_sheet foreign key (order_id)
      references t_so_sheet (id);

alter table t_sys_app_info add constraint fk_app_info_ref_app_release foreign key (release_id)
      references t_sys_app_release (id);

alter table t_sys_app_release add constraint fk_app_release_ref_app_info foreign key (app_info_id)
      references t_sys_app_info (id);

alter table t_sys_app_release add constraint fk_app_release_ref_user foreign key (issue_user_id)
      references t_sys_user (id);

alter table t_sys_app_release add constraint fk_app_release_upgrade_ref_param foreign key (force_upgrade)
      references t_sys_parameter (id);

alter table t_sys_article add constraint fk_article_is_show_ref_param foreign key (is_show)
      references t_sys_parameter (id);

alter table t_sys_article add constraint fk_article_sys_flag_ref_param foreign key (is_sys_flag)
      references t_sys_parameter (id);

alter table t_sys_article add constraint fk_article_type_id_ref_art_type foreign key (type_id)
      references t_sys_article_type (id);

alter table t_sys_article add constraint fk_article_usr_id_ref_usr foreign key (issue_user_id)
      references t_sys_user (id);

alter table t_sys_article_type add constraint fk_article_is_show_ref_param foreign key (is_show)
      references t_sys_parameter (id);

alter table t_sys_article_type add constraint fk_article_parent_id_ref_article foreign key (parent_id)
      references t_sys_article_type (id);

alter table t_sys_audit_log add constraint fk_sys_audit_operate_ref_param foreign key (audit_operate)
      references t_sys_parameter (id);

alter table t_sys_audit_log add constraint fk_sys_audit_type_ref_param foreign key (audit_type)
      references t_sys_parameter (id);

alter table t_sys_audit_log add constraint fk_sys_audit_user_ref_user foreign key (audit_user_id)
      references t_sys_user (id);

alter table t_sys_config_detail add constraint fk_config_detail_ref_config foreign key (config_id)
      references t_sys_config (id);

alter table t_sys_feedback add constraint fk_feedback_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_sys_feedback add constraint fk_sys_feedback_ref_param foreign key (feedback_type)
      references t_sys_parameter (id);

alter table t_sys_module add constraint fk_module_menu_ref_param foreign key (menu_flag)
      references t_sys_parameter (id);

alter table t_sys_module add constraint fk_module_pid_ref_mudule foreign key (parent_id)
      references t_sys_module (id);

alter table t_sys_module add constraint fk_sys_module_stat_ref_dict foreign key (status)
      references t_sys_parameter (id);

alter table t_sys_notify add constraint fk_notify_extend_ref_param foreign key (send_extend)
      references t_sys_parameter (id);

alter table t_sys_notify add constraint fk_notify_issue_usr_ref_usr foreign key (issue_user_id)
      references t_sys_user (id);

alter table t_sys_notify add constraint fk_notify_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_sys_notify add constraint fk_notify_type_ref_param foreign key (notify_type)
      references t_sys_parameter (id);

alter table t_sys_notify add constraint fk_sys_notify_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_sys_notify add constraint fk_sys_notify_sent_ref_param foreign key (is_sent)
      references t_sys_parameter (id);

alter table t_sys_notify_log add constraint fk_notify_push_his_ref_notify foreign key (notify_id)
      references t_sys_notify (id);

alter table t_sys_notify_log add constraint fk_notify_push_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_sys_operation_log add constraint fk_log_ref_module foreign key (module_id)
      references t_sys_module (id);

alter table t_sys_operation_log add constraint fk_op_user_ref_user foreign key (user_id)
      references t_sys_user (id);

alter table t_sys_parameter add constraint fk_param_val_ref_type foreign key (type_id)
      references t_sys_parameter_type (id);

alter table t_sys_region add constraint fk_region_parent_ref_region foreign key (parent_id)
      references t_sys_region (id);

alter table t_sys_region add constraint fk_region_type_ref_param foreign key (region_type)
      references t_sys_parameter (id);

alter table t_sys_relative_module add constraint fk_relative_module_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_sys_relative_module add constraint fk_relative_module_show_ref_param foreign key (is_show)
      references t_sys_parameter (id);

alter table t_sys_role_rights add constraint fk_rolel_rights_ref_module foreign key (module_id)
      references t_sys_module (id);

alter table t_sys_role_rights add constraint fk_rolel_rights_ref_role foreign key (role_id)
      references t_sys_role (id);

alter table t_sys_role_user add constraint fk_role_user_ref_role foreign key (role_id)
      references t_sys_role (id);

alter table t_sys_role_user add constraint fk_role_user_ref_user foreign key (user_id)
      references t_sys_user (id);

alter table t_sys_user add constraint fk_user_is_admin_ref_param foreign key (is_admin)
      references t_sys_parameter (id);

alter table t_sys_user add constraint fk_user_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_sys_verify_code add constraint fk_verify_code_type_ref_param foreign key (usage_type)
      references t_sys_parameter (id);

alter table t_sys_verify_code add constraint fk_verify_type_ref_param foreign key (verify_type)
      references t_sys_parameter (id);

alter table t_sys_warehouse add constraint fk_sys_warehouse_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_sys_warehouse_region add constraint fk_wh_region_ref_region foreign key (region_id)
      references t_sys_region (id);

alter table t_sys_warehouse_region add constraint fk_wh_region_ref_wh foreign key (warehouse_id)
      references t_sys_warehouse (id);

alter table t_vip add constraint fk_vip_audit_status_ref_param foreign key (audit_status)
      references t_sys_parameter (id);

alter table t_vip add constraint fk_vip_audit_user_ref_user foreign key (audit_user_id)
      references t_sys_user (id);

alter table t_vip add constraint fk_vip_email_verify_ref_param foreign key (email_verify_flag)
      references t_sys_parameter (id);

alter table t_vip add constraint fk_vip_info_pid_ref_vip foreign key (parent_id)
      references t_vip (id);

alter table t_vip add constraint fk_vip_merchant_ref_param foreign key (merchant_flag)
      references t_sys_parameter (id);

alter table t_vip add constraint fk_vip_merchant_type_ref_mtype foreign key (vip_type_id)
      references t_vip_type (id);

alter table t_vip add constraint fk_vip_mobile_verify_ref_param foreign key (mobile_verify_flag)
      references t_sys_parameter (id);

alter table t_vip add constraint fk_vip_ref_vip_rank foreign key (rank_id)
      references t_vip_rank (id);

alter table t_vip add constraint fk_vip_sex_ref_param foreign key (sex)
      references t_sys_parameter (id);

alter table t_vip add constraint fk_vip_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_vip_address add constraint fk_fk_vip_address_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_address add constraint fk_vip_addr_city_ref_region foreign key (city_id)
      references t_sys_region (id);

alter table t_vip_address add constraint fk_vip_addr_county_ref_region foreign key (county_id)
      references t_sys_region (id);

alter table t_vip_address add constraint fk_vip_addr_district_ref_region foreign key (district_id)
      references t_sys_region (id);

alter table t_vip_address add constraint fk_vip_addr_is_default_ref_param foreign key (default_flag)
      references t_sys_parameter (id);

alter table t_vip_address add constraint fk_vip_addr_provice_ref_region foreign key (province_id)
      references t_sys_region (id);

alter table t_vip_blog add constraint fk_org_blog_show_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_vip_blog add constraint fk_vip_blog_flag_ref_param foreign key (blog_flag)
      references t_sys_parameter (id);

alter table t_vip_blog add constraint fk_vip_blog_type_id_ref_type foreign key (blog_type)
      references t_vip_blog_type (id);

alter table t_vip_blog add constraint fk_vip_org_blog_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_blog_cmt add constraint fk_blog_cmt_parent_ref_cmt foreign key (parent_id)
      references t_vip_blog_cmt (id);

alter table t_vip_blog_cmt add constraint fk_blog_cmt_ref_blog foreign key (blog_id)
      references t_vip_blog (id);

alter table t_vip_blog_cmt add constraint fk_vip_blog_cmt_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_blog_cmt add constraint fk_vip_blog_cmt_status_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_vip_blog_likes add constraint fk_blog_likes_ref_blog foreign key (blog_id)
      references t_vip_blog (id);

alter table t_vip_blog_likes add constraint fk_blog_likes_ref_blog_cmt foreign key (blog_cmt_id)
      references t_vip_blog_cmt (id);

alter table t_vip_blog_likes add constraint fk_vip_blog_likes_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_blog_photo add constraint fk_org_blog_phpto_ref_blog foreign key (blog_id)
      references t_vip_blog (id);

alter table t_vip_blog_type add constraint fk_blog_type_parent_ref_blog_type foreign key (parent_id)
      references t_vip_blog_type (id);

alter table t_vip_case add constraint fk_org_case_ref_case_type foreign key (type_id)
      references t_vip_case_type (id);

alter table t_vip_case add constraint fk_org_case_ref_param foreign key (case_flag)
      references t_sys_parameter (id);

alter table t_vip_case add constraint fk_org_case_show_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_vip_case add constraint fk_sys_org_case_ref_param foreign key (audit_status)
      references t_sys_parameter (id);

alter table t_vip_case add constraint fk_vip_case_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_case add constraint fk_vip_org_case_ref_user foreign key (audit_user_id)
      references t_sys_user (id);

alter table t_vip_case_detail add constraint fk_org_case_detail_ref_case foreign key (case_id)
      references t_vip_case (id);

alter table t_vip_case_detail add constraint fk_org_case_detail_ref_prod foreign key (product_id)
      references t_product (id);

alter table t_vip_case_photo add constraint fk_vip_case_photo_ref_case foreign key (case_id)
      references t_vip_case (id);

alter table t_vip_case_type add constraint fk_vip_case_type_ref_vip_type foreign key (vip_type_id)
      references t_vip_type (id);

alter table t_vip_case_type_prop add constraint fk_case_type_prop_input_ref_param foreign key (input_type)
      references t_sys_parameter (id);

alter table t_vip_case_type_prop add constraint fk_case_type_prop_multi_ref_param foreign key (multi_select)
      references t_sys_parameter (id);

alter table t_vip_case_type_prop add constraint fk_case_type_prop_ref_type foreign key (case_type_id)
      references t_vip_case_type (id);

alter table t_vip_case_type_prop add constraint fk_case_type_prop_required_ref_param foreign key (is_required)
      references t_sys_parameter (id);

alter table t_vip_case_type_prop_val add constraint fk_case_type_prop_val_ref_prop foreign key (prop_id)
      references t_vip_case_type_prop (id);

alter table t_vip_collect add constraint fk_vip_collect_ref_activity foreign key (package_id)
      references t_activity (id);

alter table t_vip_collect add constraint fk_vip_collect_ref_case foreign key (case_id)
      references t_vip_case (id);

alter table t_vip_collect add constraint fk_vip_collect_ref_product foreign key (product_id)
      references t_product (id);

alter table t_vip_collect add constraint fk_vip_collect_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_concern add constraint fk_concern_ref__vip_id_ref_vip foreign key (ref_vip_id)
      references t_vip (id);

alter table t_vip_concern add constraint fk_concern_vip_id_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_coupon add constraint fk_coupon_ref_cp_type foreign key (coupon_type_id)
      references t_vip_coupon_type (id);

alter table t_vip_coupon add constraint fk_coupon_ref_so_sheet foreign key (order_id)
      references t_so_sheet (id);

alter table t_vip_coupon add constraint fk_coupon_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_coupon_log add constraint fk_coupon_log_ref_coupon foreign key (coupon_id)
      references t_vip_coupon (id);

alter table t_vip_coupon_log add constraint fk_coupon_log_ref_so foreign key (order_id)
      references t_so_sheet (id);

alter table t_vip_coupon_type add constraint fk_couopn_send_type_ref_param foreign key (send_type)
      references t_sys_parameter (id);

alter table t_vip_coupon_type add constraint fk_coupon_type_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_extend add constraint fk_vip_ext_audit_stat_ref_stat foreign key (audit_status)
      references t_sys_parameter (id);

alter table t_vip_extend add constraint fk_vip_ext_audit_usr_ref_usr foreign key (audit_user_id)
      references t_sys_user (id);

alter table t_vip_extend add constraint fk_vip_extend_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_module add constraint fk_vip_mod_menu_ref_param foreign key (menu_flag)
      references t_sys_parameter (id);

alter table t_vip_module add constraint fk_vip_mod_merchant_ref_param foreign key (merchant_flag)
      references t_sys_parameter (id);

alter table t_vip_module add constraint fk_vip_mod_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_vip_operation_log add constraint fk_vip_op_log_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_operation_log add constraint fk_vip_op_log_ref_vmodule foreign key (module_id)
      references t_vip_module (id);

alter table t_vip_org_gallery add constraint fk_org_gallery_ref_org foreign key (organization_id)
      references t_vip_organization (id);

alter table t_vip_organization add constraint fk_org_city_ref_region foreign key (city_id)
      references t_sys_region (id);

alter table t_vip_organization add constraint fk_org_country_ref_region foreign key (country_id)
      references t_sys_region (id);

alter table t_vip_organization add constraint fk_org_province_ref_region foreign key (province_id)
      references t_sys_region (id);

alter table t_vip_organization add constraint fk_org_ref_vip foreign key (vip_id)
      references t_vip (id);

alter table t_vip_organization add constraint fk_org_stat_ref_param foreign key (status)
      references t_sys_parameter (id);

alter table t_vip_organization add constraint fk_vip_org_audit_ref_param foreign key (audit_status)
      references t_sys_parameter (id);

alter table t_vip_organization add constraint fk_vip_org_audit_user_ref_user foreign key (audit_user_id)
      references t_sys_user (id);

alter table t_vip_product_type add constraint fk_vip_ptype_ref_merch_type foreign key (vip_type_id)
      references t_vip_type (id);

alter table t_vip_product_type add constraint fk_vip_ptype_ref_product foreign key (product_type_id)
      references t_product_type (id);

alter table t_vip_product_type add constraint fk_vip_ptype_ref_vip_type foreign key (vip_id)
      references t_vip (id);

alter table t_vip_type add constraint fk_vip_type_merc_flag_ref_param foreign key (merchant_flag)
      references t_sys_parameter (id);

