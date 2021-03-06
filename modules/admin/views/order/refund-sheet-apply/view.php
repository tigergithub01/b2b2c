<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\Module;
use app\models\b2b2c\RefundSheetApply;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\RefundSheetApply */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Refund Sheet Applies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-sheet-apply-view">
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
            //'sheet_type_id',
            'code',
            // 'vip_id',
            'vip.vip_name',
            // 'order_id',
            'order.code',
            'reason',
            // 'status',
            'status0.param_val',
            'apply_date',
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
	       
	        
	        <?php if($model->status==RefundSheetApply::status_approved ) {?>    
	        	<?= Html::a(Yii::t('app', '去退款'), ['/admin/order/refund-sheet/create', 'refund_apply_id' => $model->id], [
		            'class' => 'btn btn-primary',
		            'data' => [
		                'method' => 'post',
		            ],
		        ]) ?>
		  <?php }?>
		  
		   <?php if($model->status==RefundSheetApply::status_need_approve ) {?>         
		        <?php echo  Html::a(Yii::t('app', '同意（告知客户退款正在处理）'), ['approve', 'id' => $model->id], [
		            'class' => 'btn btn-primary',
		            'data' => [
		                'confirm' => Yii::t('app', 'Whether to submit?'),
		                'method' => 'post',
		            ],
		        ]) ?>
		        
	        
		        <?php echo  Html::a(Yii::t('app', 'reject'), ['reject', 'id' => $model->id/* , 'audit_memo' => 'Reject' */], [
		            'class' => 'btn btn-danger',
		            'data' => [
		                'confirm' => Yii::t('app', 'Whether to submit?'),
		                'method' => 'post',
		            ],
		        ]) ?>
	     	<?php }?>
	        
	    </div>
    
    </div>

</div>
