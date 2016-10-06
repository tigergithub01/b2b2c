<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysAdInfo */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Sys Ad Info'),
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Ad Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-ad-info-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
