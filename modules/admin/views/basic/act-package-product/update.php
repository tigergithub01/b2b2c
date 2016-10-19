<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ActPackageProduct */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Act Package Product'),
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Act Package Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="act-package-product-update">

    <?= $this->render('_form', [
        'model' => $model,
    		'activityList' => $activityList,
    		'productList' => $productList,
    ]) ?>

</div>
