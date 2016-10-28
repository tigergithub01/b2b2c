<?php

use yii\helpers\Html;
use app\modules\merchant\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Activity */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Activity'),
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="activity-update">

    <?= $this->render('_form', [
        'model' => $model,
    		'activityTypeList' => $activityTypeList,
    		'vipList' => $vipList,
    		'sysUserList' => $sysUserList,
    		'yesNoList' => $yesNoList,
    		'auditStatList' => $auditStatList,
    ]) ?>

</div>
