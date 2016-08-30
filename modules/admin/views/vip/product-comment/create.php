<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ProductComment */

$this->title = Yii::t('app', 'Create Product Comment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-comment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
