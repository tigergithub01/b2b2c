<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysModule */

$this->title = Yii::t('app', 'Create Sys Module');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Modules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-module-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
