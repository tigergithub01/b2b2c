<?php

use yii\helpers\Html;
use app\modules\vip\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipConcern */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Vip Concern'),
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Concerns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-concern-update">

    <?= $this->render('_form', [
        'model' => $model,
    		'vipList' => $vipList,
    		'merchantList' => $merchantList,
    ]) ?>

</div>
