<?php

use app\modules\vip\models\VipConst;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
               <?php if(Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->thumb_url){?>
                	<img src="<?= Yii::$app->request->hostInfo . '/' . Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->thumb_url ?>" class="img-circle" alt="User Image"/>
               	<?php } else {?>
               		<img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
               	<?php }?>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->vip_name; /* echo $_SESSION['login_admin_user']['user_id']; */?></p>
            </div>
        </div>


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                	['label' => '个人资料', 'icon' => 'fa fa-table','url' => ['member/vip/vip/view'],],
                	// ['label' => '我的关注', 'icon' => 'fa fa-table','url' => ['member/vip/vip-concern/index'],],
                	['label' => '我的收藏', 'icon' => 'fa fa-table','url' => ['member/vip/vip-collect/index'],],
                	['label' => '我的消息', 'icon' => 'fa fa-table','url' => ['member/system/sys-notify-log/index'],],
                	['label' => '订单咨询', 'icon' => 'fa fa-table','url' => ['member/order/quotation/index'],],
                	['label' => '我的订单', 'icon' => 'fa fa-table','url' => ['member/order/so-sheet/index'],],
                	//['label' => '退款申请', 'icon' => 'fa fa-table','url' => ['member/order/refund-sheet-apply/index'],],
                	['label' => '密码修改', 'icon' => 'fa fa-table','url' => ['member/system/modify-pwd/index'],],
                ],
            ]
        ) ?>

    </section>

</aside>
