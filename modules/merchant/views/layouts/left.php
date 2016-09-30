<?php

use app\modules\merchant\models\MerchantConst;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)['vip_id']; /* echo $_SESSION['login_admin_user']['user_id']; */?></p>
            </div>
        </div>


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                	['label' => '我的消息', 'icon' => 'fa fa-table','url' => ['basic/product/index'],],
                	['label' => '我的动态', 'icon' => 'fa fa-table','url' => ['basic/product/index'],],
                	['label' => '订单管理', 'icon' => 'fa fa-table','url' => '#',
                		'items' => [
                				['label' => '订单列表',  'url' => ['order/so-sheet/index'],'icon' => 'fa fa-circle-o',],
                				['label' => '退款单', 'url' => ['order/refund-sheet/index'],'icon' => 'fa fa-circle-o',],
                		],
                	],
                	['label' => '服务管理', 'icon' => 'fa fa-table','url' => '#',
                		'items' => [
                				['label' => '个人定价', 'url' => ['order/refund-sheet/index'],'icon' => 'fa fa-circle-o',],
                				['label' => '团体服务', 'url' => ['system/modify-pwd/index'],'icon' => 'fa fa-circle-o',],
                		],
                	],
                	['label' => '案例管理', 'icon' => 'fa fa-table','url' => '#',
                			'items' => [
                					['label' => '个人案例',  'url' => ['organization/vip-organization/index'],'icon' => 'fa fa-circle-o'],
                					['label' => '团体案例',  'url' => ['vip/vip-org-case/index'],'icon' => 'fa fa-circle-o',],
                			],
                	],
                	['label' => '个人中心', 'icon' => 'fa fa-table','url' => '#',
                			'items' => [
                					['label' => '个人资料', 'url' => ['order/refund-sheet/index'],'icon' => 'fa fa-circle-o',],
                					['label' => '密码修改', 'url' => ['system/modify-pwd/index'],'icon' => 'fa fa-circle-o',],
                			],
       				 ],
                ],
            ]
        ) ?>

    </section>

</aside>
