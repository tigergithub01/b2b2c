<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCase */

$this->title = Yii::t('app', 'Create Vip Case');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Cases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-case-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
