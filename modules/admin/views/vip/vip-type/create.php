<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipType */

$this->title = Yii::t('app', 'Create Vip Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
