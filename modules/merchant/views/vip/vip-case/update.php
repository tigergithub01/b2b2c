<?php

use yii\helpers\Html;
use app\modules\merchant\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCase */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Vip Case'),
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Cases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-case-update">

    <?= $this->render('_form', [
        'model' => $model,
    		'vipCaseTypeList' => $vipCaseTypeList,
    		'yesNoList' => $yesNoList,
    		'auditStatList' => $auditStatList,
    		'caseFlagList' => $caseFlagList,
    		'vipList' => $vipList,
    		'sysUserList' => $sysUserList,
    		'vipCasePhotoThumbs' => $vipCasePhotoThumbs,
    		'coverThumb'  => $coverThumb,
    ]) ?>

</div>
