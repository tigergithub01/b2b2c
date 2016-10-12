<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCaseType */

$this->title = Yii::t('app', 'Create Vip Case Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Case Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-case-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
