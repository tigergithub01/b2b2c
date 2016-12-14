<?php

use yii\helpers\Html;
use app\modules\merchant\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCase */

$this->title = Module::t('app', 'Create Vip Case');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Cases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-case-create">

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
