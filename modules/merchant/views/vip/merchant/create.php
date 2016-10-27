<?php

use yii\helpers\Html;
use app\modules\merchant\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Vip */

$this->title = Module::t('app', 'Create Merchant');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Merchants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-create">

    <?= $this->render('_form', [
        	'model' => $model,
    		'vipOrganization' => $vipOrganization,
    		'vipExtend' => $vipExtend,
    		'product' => $product,
    		'yesNoList' => $yesNoList,
    		'vipRankList' => $vipRankList,
    		'auditStatusList' => $auditStatusList,
    		'vipTypeList' => $vipTypeList,
    		'sexList' => $sexList,
    		'userList' => $userList,
    ]) ?>

</div>
