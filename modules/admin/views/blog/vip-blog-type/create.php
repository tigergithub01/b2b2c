<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipBlogType */

$this->title = Yii::t('app', 'Create Vip Blog Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Blog Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-blog-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
