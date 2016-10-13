<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Vip */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Vip',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vips'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-update">

    <?= $this->render('_form', [
       		'model' => $model,
    		'yesNoList' => $yesNoList,
    		'vipRankList' => $vipRankList,
    		'auditStatusList' => $auditStatusList,
    		'vipTypeList' => $vipTypeList,
    		'sexList' => $sexList,
    		'userList' => $userList,
    ]) ?>

</div>
