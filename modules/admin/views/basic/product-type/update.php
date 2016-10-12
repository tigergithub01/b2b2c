<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ProductType */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Product Type'),
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Product Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    	'pTypeList' => $pTypeList,
    ]) ?>

</div>
