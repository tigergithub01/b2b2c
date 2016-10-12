<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipOperationLog */

$this->title = Yii::t('app', 'Create Vip Operation Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Operation Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-operation-log-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
