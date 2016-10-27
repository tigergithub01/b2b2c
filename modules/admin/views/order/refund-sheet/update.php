<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\RefundSheet */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Refund Sheet'),
]) . $model->code;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Refund Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->code, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="refund-sheet-update">

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
