<?php

use app\models\b2b2c\VipBlog;

?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->session->get('login_admin_user')['user_id']; /* echo $_SESSION['login_admin_user']['user_id']; */?></p>
            </div>
        </div>


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                	['label' => '基础资料', 'icon' => 'fa fa-table','url' => '#',
                			'items' => [
                					['label' => '产品分类',  'url' => ['basic/product-type/index'],'icon' => 'fa fa-circle-o'],
                					['label' => '产品品牌',  'url' => ['basic/product-brand/index'],'icon' => 'fa fa-circle-o'],
                					['label' => '个人服务',  'url' => ['basic/product/index'],'icon' => 'fa fa-circle-o'],
                					['label' => '团体服务',  'url' => ['basic/activity/index'],'icon' => 'fa fa-circle-o',],
                                 ],
					],
                	['label' => '会员管理', 'icon' => 'fa fa-table','url' => '#',
                			'items' => [
                					['label' => '会员类型',  'url' => ['vip/vip-type/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '会员信息',  'url' => ['vip/vip/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '会员评论',  'url' => ['vip/product-comment/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '会员日志',  'url' => ['vip/vip-operation-log/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '收藏列表',  'url' => ['vip/vip-collect/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '关注列表',  'url' => ['vip/vip-concern/index'],'icon' => 'fa fa-circle-o',],
                			],
                	],
                	['label' => '商户管理', 'icon' => 'fa fa-table','url' => '#',
                			'items' => [
                					['label' => '商户列表',  'url' => ['vip/merchant/index'],'icon' => 'fa fa-circle-o'],
                					['label' => '案例分类',  'url' => ['vip/vip-case-type/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '案例列表',  'url' => ['vip/vip-case/index'],'icon' => 'fa fa-circle-o',],
                			],
                	],
                	['label' => '论坛管理', 'icon' => 'fa fa-table','url' => '#',
                		'items' => [
                				['label' => '帖子分类',  'url' => ['blog/vip-blog-type/index'],'icon' => 'fa fa-circle-o'],
                				['label' => '帖子列表',  'url' => ['blog/vip-blog/index'],'icon' => 'fa fa-circle-o'],
                				['label' => '帖子评价',  'url' => ['blog/vip-blog-cmt/index'],'icon' => 'fa fa-circle-o',],
                		],
                	],
                	['label' => '订单管理', 'icon' => 'fa fa-table','url' => '#',
                			'items' => [
                					['label' => '订单列表',  'url' => ['order/so-sheet/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '退款申请单', 'url' => ['order/refund-sheet-apply/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '退款单', 'url' => ['order/refund-sheet/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '退货申请单', 'url' => ['order/return-apply/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '退货单', 'url' => ['order/return-sheet/index'],'icon' => 'fa fa-circle-o',],
                			],
                	],
                	['label' => '系统设置', 'icon' => 'fa fa-table','url' => '#',
                			'items' => [
                					['label' => '支付方式',  'url' => ['system/pay-type/index'], 'icon' => 'fa fa-circle-o',],
                					['label' => '用户信息', 'url' => ['system/sys-user/index'],'icon' => 'fa fa-circle-o',],
//                 					['label' => '角色信息', 'url' => ['system/sys-role/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '系统日志', 'url' => ['system/sys-operation-log/index'],'icon' => 'fa fa-circle-o',],
//                 					['label' => '模块信息', 'url' => ['system/sys-module/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '广告图设置', 'url' => ['system/sys-ad-info/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '密码修改', 'url' => ['system/modify-pwd/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '文章管理', 'url' => ['system/sys-article/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '地区信息', 'url' => ['system/sys-region/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '消息列表', 'url' => ['system/sys-notify/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '单据类型', 'url' => ['system/sheet-type/index'],'icon' => 'fa fa-circle-o',],
                					['label' => 'API测试', 'url' => ['api/api-test/index'],'icon' => 'fa fa-circle-o',],
                			],
       				 ],
                ],
            ]
        ) ?>

    </section>

</aside>
