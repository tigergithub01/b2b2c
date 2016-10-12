<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCollect */

$this->title = Yii::t('app', 'Create Vip Collect');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Collects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-collect-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
