<?php

use yii\helpers\Html;
use app\modules\vip\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\RefundSheetApply */

$this->title = Module::t('app', 'Create Refund Sheet Apply');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Refund Sheet Applies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-sheet-apply-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'vipList' => $vipList,
        'refundApplyStatusList' => $refundApplyStatusList,
        'soSheetList' => $soSheetList,
    ]) ?>

</div>
