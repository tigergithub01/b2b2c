<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SoSheet */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'So Sheet'),
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'So Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="so-sheet-update">

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
    		'sheetTypeList' => $sheetTypeList,
    		'serviceStyleList' => $serviceStyleList,
    		'relatedServiceList' => $relatedServiceList,
    ]) ?>

</div>
