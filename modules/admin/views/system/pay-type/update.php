<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\PayType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('app','Pay_Type'),
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pay_Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pay-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    	'yesNoList'=>$yesNoList,
    ]) ?>

</div>
