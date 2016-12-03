<?php

use yii\helpers\Html;
use app\modules\merchant\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Quotation */

$this->title = Module::t('app', 'Create Quotation');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Quotations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-create">

    <?= $this->render('_form', [
        'model' => $model,
    		'vipList' => $vipList,
    		'merchantList' => $merchantList,
    		'serviceStyleList' => $serviceStyleList,
    		'relatedServiceList' => $relatedServiceList,
    		'statusList' => $statusList,
    ]) ?>

</div>
