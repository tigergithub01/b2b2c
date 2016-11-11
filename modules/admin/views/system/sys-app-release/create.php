<?php




use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysAppRelease */

$this->title = Module::t('app', 'Create Sys App Release');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys App Releases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-app-release-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'yesNoList'=>$yesNoList,
    	'sysAppInfoList' => $sysAppInfoList,
    ]) ?>

</div>
