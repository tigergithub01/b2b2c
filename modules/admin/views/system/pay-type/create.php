<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\PayType */

$this->title = Module::t('app', 'Create Pay Type');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Pay Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'yesNoList'=>$yesNoList,
    ]) ?>

</div>
