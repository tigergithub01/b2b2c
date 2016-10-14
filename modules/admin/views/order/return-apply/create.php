<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ReturnApply */

$this->title = Yii::t('app', 'Create Return Apply');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Return Applies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="return-apply-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
