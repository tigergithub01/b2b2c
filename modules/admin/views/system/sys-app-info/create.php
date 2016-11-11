<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysAppInfo */

$this->title = Yii::t('app', 'Create Sys App Info');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys App Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-app-info-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
