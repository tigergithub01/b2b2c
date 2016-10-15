<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SoSheet */

$this->title = Module::t('app', 'Create So Sheet');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'So Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-sheet-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
