<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipBlog */

$this->title = Yii::t('app', 'Create Vip Blog');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-blog-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
