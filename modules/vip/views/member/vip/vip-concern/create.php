<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipConcern */

$this->title = Module::t('app', 'Create Vip Concern');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Concerns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-concern-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'vipList' => $vipList,
    	'merchantList' => $merchantList,
    ]) ?>

</div>
