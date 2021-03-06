<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SoSheetDetail */

$this->title = Module::t('app', 'Create So Sheet Detail');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'So Sheet Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-sheet-detail-create">

    <?= $this->render('_form', [
        'model' => $model,
    		'activityList' => $activityList,
    		'productList' => $productList,
    		'soSheetList' => $soSheetList,
    ]) ?>

</div>
