<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysNotify */

$this->title = Module::t('app', 'Create Sys Notify');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Notifies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-notify-create">

    <?= $this->render('_form', [
        'model' => $model,
    		'yesNoList' => $yesNoList,
    		'sendExtendList' => $sendExtendList,
    		'sysUserList' => $sysUserList,
    		'notifyTypeList' => $notifyTypeList,
    		'vipList' => $vipList,
    ]) ?>

</div>
