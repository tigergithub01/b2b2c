<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysAppRelease */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys App Releases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-app-release-view">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title" style="visibility: visible;"><?= Html::encode($this->title) ?></h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool"
					data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>

		<div class="box-body">
		    <?= DetailView::widget([
		        'model' => $model,
		        'attributes' => [
		            'id',
            'name',
            'ver_no',
            'upgrade_desc:ntext',
            //'force_upgrade',
            'forceUpgrade.param_val',
            'issue_date',
            //'issue_user_id',
            'issueUser.user_id',
            //'app_path',
        	[
        		'attribute' => 'app_path',
        		'format' =>'raw',
        		'value'=>empty($model->app_path)?'':'<a href="'.Yii::$app->request->hostInfo . '/' . $model->app_path. '">'.$model->app_path.'</a>'
        				],
            //'app_info_id',
            'appInfo.name',
		        ],
		    ]) ?>
    	</div>
    
	    <div class="box-footer">
	    	<?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
	                'method' => 'post',
	            ],
	        ]) ?>
	    </div>
    
    </div>

</div>
