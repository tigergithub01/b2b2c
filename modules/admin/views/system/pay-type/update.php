<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\PayType */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app','Pay_Type'),
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Pay_Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pay-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    	'yesNoList'=>$yesNoList,
    ]) ?>

</div>
