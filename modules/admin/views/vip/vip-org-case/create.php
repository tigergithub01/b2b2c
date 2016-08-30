<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipOrgCase */

$this->title = Yii::t('app', 'Create Vip Org Case');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vip Org Cases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-org-case-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
