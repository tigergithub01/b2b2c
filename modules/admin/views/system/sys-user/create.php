<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysUser */

$this->title = Module::t('app', 'Create Sys User');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-user-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'yesNoList' => $yesNoList,
    ]) ?>

</div>
