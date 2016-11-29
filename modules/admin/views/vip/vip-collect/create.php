<?php

use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCollect */

$this->title = Module::t('app', 'Create Vip Collect');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Collects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-collect-create">

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
