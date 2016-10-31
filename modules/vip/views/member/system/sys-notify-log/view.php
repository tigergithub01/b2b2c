<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\vip\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysNotifyLog */

$this->title = $model->notify->title;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Notify Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-notify-log-view">
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
		            //'id',
		            'notify.title' ,
		        	'notify.content:ntext' ,
            //'notify_id',
		    // 'content:ntext',
            // 'vip_id',
            'create_date',
            'read_date',
            // 'expiration_time',
		        ],
		    ]) ?>
    	</div>
    
	    <div class="box-footer">
	    	<?php // echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	        <?php /* echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
	                'method' => 'post',
	            ],
	        ])*/ ?>
	    </div>
    
    </div>

</div>
