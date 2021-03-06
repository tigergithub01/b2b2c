<?php

use yii\helpers\Html;
use app\modules\merchant\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Quotation */

$this->title = Module::t('app', 'Reply Quotation').'：' . $model->code;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Quotations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->code, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', '回复');
?>
<div class="quotation-update">

    <?= $this->render('_form', [
        'model' => $model,
    		'vipList' => $vipList,
    		'merchantList' => $merchantList,
    		'serviceStyleList' => $serviceStyleList,
    		'relatedServiceList' => $relatedServiceList,
    		'statusList' => $statusList,
    ]) ?>

</div>
