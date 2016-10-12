<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipConcern */

$this->title = Yii::t('app', 'Create Vip Concern');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Concerns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-concern-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
