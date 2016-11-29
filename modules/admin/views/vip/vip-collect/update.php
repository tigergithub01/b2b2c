<?php

use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCollect */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Vip Collect'),
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Collects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-collect-update">

    <?= $this->render('_form', [
        'model' => $model,
    		'vipList' => $vipList,
    		'merchantList' => $merchantList,
    		'productList' => $productList,
    		'vipCaseList' => $vipCaseList,
    		'activityList' => $activityList,
    		'collectTypeList' => $collectTypeList,
    ]) ?>

</div>
