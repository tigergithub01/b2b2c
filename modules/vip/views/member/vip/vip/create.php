<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Vip */

$this->title = Module::t('app', 'Create Vip');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vips'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-create">

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
