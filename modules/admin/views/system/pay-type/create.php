<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\PayType */

$this->title = Yii::t('app', 'Create_Pay_Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pay_Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'yesNoList'=>$yesNoList,
    ]) ?>

</div>
