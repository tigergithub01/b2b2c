<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Activity */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-view">
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
            // 'activity_type',
		    'activityType.name',
            // 'activity_scope',
		    'actScopes.param_val',
            'start_time',
            'end_date',
            'description',
            'package_price',
            'deposit_amount',
            'buy_limit_num',
            // 'vip_id',
            'vip.vip_id',
            // 'img_url:url',
            // 'thumb_url:url',
            // 'img_original',
        		[
        		'attribute' => 'img_url',
        		'format' =>'raw',
        		'value'=>Html::img(Yii::$app->request->hostInfo . '/' . $model->img_url,['width'=>220,'height'=>220]),
        		],
        		[
        				'attribute' => 'img_url',
        				'format' =>'raw',
        				'value'=>Html::a($model->img_url,Yii::$app->request->hostInfo . '/' . $model->img_url,['target'=>'_blank',]),
        		],
        		[
        				'attribute' => 'thumb_url',
        				'format' =>'raw',
        				'value'=>Html::a($model->thumb_url,Yii::$app->request->hostInfo . '/' . $model->thumb_url,['target'=>'_blank',]),
        		],
        		[
        				'attribute' => 'img_original',
        				'format' =>'raw',
        				'value'=>Html::a($model->img_original,Yii::$app->request->hostInfo . '/' . $model->img_original,['target'=>'_blank',]),
        		],
            // 'audit_status',
            'auditStatus.param_val',
            // 'audit_user_id',
           	'auditUser.user_id',
            'audit_date',
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
