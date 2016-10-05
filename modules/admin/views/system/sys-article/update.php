<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysArticle */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sys Article',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-article-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
