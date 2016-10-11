<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysRegion */

$this->title = Module::t('app', 'Create Sys Region');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Regions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-region-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'regionTypeList' => $regionTypeList,
    ]) ?>

</div>
