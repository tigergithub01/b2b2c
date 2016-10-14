<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ProductBrand */

$this->title = Module::t('app', 'Create Product Brand');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-brand-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
