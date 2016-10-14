<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCaseType */

$this->title = Module::t('app', 'Create Vip Case Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Case Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-case-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    		'vipTypeList' => $vipTypeList
    ]) ?>

</div>
