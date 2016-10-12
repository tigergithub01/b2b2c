<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ProductType */

$this->title = Module::t('app', 'Create Product Type');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Product Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'pTypeList' => $pTypeList,
    ]) ?>

</div>
