<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SheetType */

$this->title = Module::t('app', 'Create Sheet Type');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sheet Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sheet-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
