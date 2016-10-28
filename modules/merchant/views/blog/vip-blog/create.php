<?php

use yii\helpers\Html;
use app\modules\merchant\Module;


/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipBlog */

$this->title = Module::t('app', 'Create Vip Blog');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-blog-create">

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
