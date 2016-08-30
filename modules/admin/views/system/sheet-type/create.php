<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SheetType */

$this->title = Yii::t('app', 'Create Sheet Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sheet Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sheet-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
