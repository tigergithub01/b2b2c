<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysNotify */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Sys Notify'),
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Notifies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-notify-update">

    <?= $this->render('_form', [
        'model' => $model,
    		'yesNoList' => $yesNoList,
    		'sendExtendList' => $sendExtendList,
    		'sysUserList' => $sysUserList,
    		'notifyTypeList' => $notifyTypeList,
    		'vipList' => $vipList,
    ]) ?>

</div>
