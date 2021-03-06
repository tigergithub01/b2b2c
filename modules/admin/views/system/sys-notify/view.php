<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysNotify */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Notifies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-notify-view">
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
		            // 'id',
            // 'notify_type',
            // 'notifyType.param_val',
            'title',
            'issue_date',
            'content:ntext',
            // 'vip_id',
            // 'vip.vip_id',
            // 'issue_user_id',
            'issueUser.user_id',
            // 'send_extend',
            'sendExtend.param_val',
            // 'status',
            'status0.param_val',
            // 'is_sent',
            'isSent.param_val',
            'sent_time',
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
	        <?= Html::a(Yii::t('app', '立即发送'), ['send-notify', 'id' => $model->id], [
	            'class' => 'btn btn-primary',
	            'data' => [
	                'confirm' => Yii::t('app', '是否发送消息?'),
	                'method' => 'post',
	            ],
	        ]) ?>
	    </div>
    
    </div>

</div>
