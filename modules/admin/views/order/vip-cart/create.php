<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCart */

$this->title = Yii::t('app', 'Create Vip Cart');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Carts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-cart-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
