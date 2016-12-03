<?php

use yii\helpers\Html;
use app\modules\merchant\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SoSheet */

$this->title = Module::t('app', 'Create So Sheet');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'So Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-sheet-create">

    <?= $this->render('_form', [
        'model' => $model,
    		'vipList' => $vipList,
    		'proviceList' => $proviceList,
    		'cityList' => $cityList,
    		'districtList' => $districtList,
    		'countryList' => $countryList,
    		'deliveryStatusList' => $deliveryStatusList,
    		'invoiceTypeList' => $invoiceTypeList,
    		'orderStatusList' => $orderStatusList,
    		'payStatusList' => $payStatusList,
    		'payTypeList' => $payTypeList,
    		'deliveryTypeList' => $deliveryTypeList,
    		'pickUpPointList' => $pickUpPointList,
    		'quotationList' => $quotationList,
    ]) ?>

</div>
