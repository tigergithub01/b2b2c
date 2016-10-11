<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysRegion */

$this->title = Yii::t('app', 'Create Sys Region');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Regions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-region-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
