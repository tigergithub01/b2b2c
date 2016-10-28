<?php

use yii\helpers\Html;
use app\modules\merchant\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Vip */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Merchant'),
]) . $model->vip_name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Merchants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-update">

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
    		'proviceList' => $proviceList,
    		'cityList' => $cityList,
    		'districtList' => $districtList,
    		'countryList' => $countryList,
    ]) ?>

</div>
