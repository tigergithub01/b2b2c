<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ReturnSheet */

$this->title = Yii::t('app', 'Create Return Sheet');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Return Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="return-sheet-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
