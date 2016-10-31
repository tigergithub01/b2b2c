<?php

use yii\helpers\Html;
use app\modules\vip\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Vip */

/* $this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Vip'),
]) . $model->id; */
$this->title = Module::t('app', '个人资料编辑');
// $this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vips'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = $this->title;
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
