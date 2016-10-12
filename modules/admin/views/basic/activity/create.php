<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Activity */

$this->title = Yii::t('app', 'Create Activity');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
