<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysUser */

$this->title = Yii::t('app', 'Create Sys User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
