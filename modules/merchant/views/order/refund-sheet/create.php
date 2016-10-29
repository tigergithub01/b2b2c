<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\RefundSheet */

$this->title = Module::t('app', 'Create Refund Sheet');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Refund Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-sheet-create">

    <?= $this->render('_form', [
        'model' => $model,
    		'merchantList' => $merchantList,
    		'orderList' => $orderList,
    		'returnList' => $returnList,
    		'refundApplyList' => $refundApplyList,
    		'userList' => $userList,
    		'refundStatusList' => $refundStatusList,
    		'vipList' => $vipList,
    ]) ?>

</div>
