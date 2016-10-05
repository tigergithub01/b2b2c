<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysAdInfo */

$this->title = Module::t('app', 'Create Sys Ad Info');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Ad Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-ad-info-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
