<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysRegion */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Sys Region'),
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Regions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-region-update">

    <?= $this->render('_form', [
        'model' => $model,
    	'regionTypeList' => $regionTypeList,
    ]) ?>

</div>
