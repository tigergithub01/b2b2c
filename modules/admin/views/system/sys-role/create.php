<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysRole */

$this->title = Yii::t('app', 'Create Sys Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-role-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
