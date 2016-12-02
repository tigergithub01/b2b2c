<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysConfig */

$this->title = Module::t('app', 'Create Sys Config');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-config-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
