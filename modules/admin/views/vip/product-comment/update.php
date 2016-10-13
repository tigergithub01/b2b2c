<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ProductComment */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Product Comment'),
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Product Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-comment-update">

    <?= $this->render('_form', [
        'model' => $model,
    		'yesNoList' => $yesNoList,
    		'vipList' => $vipList,
    		'productList' => $productList,
    		'cmtRankList' => $cmtRankList,
    ]) ?>

</div>
