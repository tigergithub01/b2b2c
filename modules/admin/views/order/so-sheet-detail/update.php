<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SoSheetDetail */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'So Sheet Detail'),
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'So Sheet Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="so-sheet-detail-update">

    <?= $this->render('_form', [
        'model' => $model,
    		'activityList' => $activityList,
    		'productList' => $productList,
    		'soSheetList' => $soSheetList,
    ]) ?>

</div>
