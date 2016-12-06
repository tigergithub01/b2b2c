<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ProductComment */

$this->title = Module::t('app', 'Create Product Comment');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Product Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-comment-create">

    <?= $this->render('_form', [
        'model' => $model,
    		'yesNoList' => $yesNoList,
    		'vipList' => $vipList,
    		'productList' => $productList,
    		'cmtRankList' => $cmtRankList,
    		'activityList' => $activityList,
    ]) ?>

</div>
