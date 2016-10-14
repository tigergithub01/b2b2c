<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ProductBrand */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Product Brand'),
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Product Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-brand-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
