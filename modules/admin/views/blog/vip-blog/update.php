<?php

use yii\helpers\Html;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipBlog */

$this->title = Module::t('app', 'Update {modelClass}: ', [
    'modelClass' => Module::t('app', 'Vip Blog'),
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vip-blog-update">

    <?= $this->render('_form', [
        'model' => $model,
    		'vipList' => $vipList,
    		'yesNoList' => $yesNoList,
    		'blogFlagList' => $blogFlagList,
    		'auditStatusList' => $auditStatusList,
    		'vipBlogTypeList' => $vipBlogTypeList,
    		'sysUserList' => $sysUserList,
    ]) ?>

</div>
