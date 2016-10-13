<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipType */

$this->title = Module::t('app', 'Create Vip Type');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'yesNoList' => $yesNoList,
    ]) ?>

</div>
