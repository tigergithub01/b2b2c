<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\RefundSheetApply */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Refund Sheet Apply'),
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Refund Sheet Applies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="refund-sheet-apply-update">

    <?= $this->render('_form', [
        'model' => $model,
    		'vipList' => $vipList,
    		'refundApplyStatusList' => $refundApplyStatusList,
    		'soSheetList' => $soSheetList,
    ]) ?>

</div>
