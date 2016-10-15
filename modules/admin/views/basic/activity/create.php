<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Activity */

$this->title = Module::t('app', 'Create Activity');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-create">

    <?= $this->render('_form', [
        'model' => $model,
    		'activityTypeList' => $activityTypeList,
    		'vipList' => $vipList,
    		'sysUserList' => $sysUserList,
    		'yesNoList' => $yesNoList,
    		'auditStatList' => $auditStatList,
    ]) ?>

</div>
