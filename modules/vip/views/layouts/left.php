<?php

use app\modules\vip\models\VipConst;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->session->get(VipConst::LOGIN_VIP_USER)['vip_id']; /* echo $_SESSION['login_admin_user']['user_id']; */?></p>
            </div>
        </div>


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                	['label' => '个人资料', 'icon' => 'fa fa-table','url' => ['basic/product/index'],],
                	['label' => '我的关注', 'icon' => 'fa fa-table','url' => ['basic/product/index'],],
                	['label' => '我的收藏', 'icon' => 'fa fa-table','url' => ['basic/product/index'],],
                	['label' => '我的消息', 'icon' => 'fa fa-table','url' => ['basic/product/index'],],
                	['label' => '我的订单', 'icon' => 'fa fa-table','url' => ['basic/product/index'],],
                ],
            ]
        ) ?>

    </section>

</aside>
