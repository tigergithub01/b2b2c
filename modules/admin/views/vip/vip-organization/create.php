<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipOrganization */

$this->title = Yii::t('app', 'Create Vip Organization');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Organizations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-organization-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
