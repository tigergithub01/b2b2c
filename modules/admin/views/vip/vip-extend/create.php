<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipExtend */

$this->title = Yii::t('app', 'Create Vip Extend');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Extends'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-extend-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
