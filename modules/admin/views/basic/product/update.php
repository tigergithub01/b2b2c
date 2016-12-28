<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Product */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Product'),
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-update">

    <?= $this->render('_form', [
        'model' => $model,
    		'ptypeList' => $ptypeList ,
    		'pbrandList' => $pbrandList,
    		'vipList' => $vipList,
    		'yesNoList' => $yesNoList,
    		'pStatusList' => $pStatusList,
    		'auditStatusList' => $auditStatusList,
    		'initialPreview' => $initialPreview,
    		'initialPreviewConfig' => $initialPreviewConfig,
    		'initialPreviewCover'  => $initialPreviewCover,
    ]) ?>

</div>
