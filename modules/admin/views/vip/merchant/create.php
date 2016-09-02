<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Vip */

$this->title = Yii::t('app', 'Create Vip');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vips'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
