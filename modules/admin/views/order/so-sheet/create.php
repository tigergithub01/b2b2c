<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SoSheet */

$this->title = Yii::t('app', 'Create So Sheet');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'So Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-sheet-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
