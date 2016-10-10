<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysArticle */

$this->title = Module::t('app', 'Create Sys Article');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-article-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'yesNoList'=>$yesNoList,
    ]) ?>

</div>
