<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ActPackageProduct */

$this->title = Module::t('app', 'Create Act Package Product');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Act Package Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="act-package-product-create">

    <?= $this->render('_form', [
        'model' => $model,
    		'activityList' => $activityList,
    		'productList' => $productList,
    ]) ?>

</div>
