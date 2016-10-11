<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysOperationLog */

$this->title = Module::t('app', 'Create Sys Operation Log');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Operation Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-operation-log-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
