<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Product */

$this->title = Module::t('app', 'Create Product');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'ptypeList' => $ptypeList ,
    	'pbrandList' => $pbrandList,
    	'orgList' => $orgList,
    	'yesNoList' => $yesNoList,
    	'pStatusList' => $pStatusList,
    	'auditStatusList' => $auditStatusList,
    ]) ?>

</div>
