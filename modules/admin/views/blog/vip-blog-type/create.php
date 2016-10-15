<?php

use yii\helpers\Html;
use app\modules\admin\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipBlogType */

$this->title = Module::t('app', 'Create Vip Blog Type');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Blog Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-blog-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'vipBlogTypeList' => $vipBlogTypeList,
    ]) ?>

</div>
