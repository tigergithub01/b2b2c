<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\merchant\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Quotation */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Quotations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-view">
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
            'code',
            //'vip_id',
		    'vip.vip_name',
            'order_amt',
            'deposit_amount',
            'create_date',
            'update_date',
            'memo',
            //'status',
            'status0.param_val',
            'consignee',
            'mobile',
            'service_date',
            'budget_amount',
            //'related_service',
            'related_service_names',
            //'service_style',
            'serviceStyle.param_val',
            //'merchant_id',
		   'merchant.vip_name'
		        ],
		    ]) ?>
    	</div>
    </div>	
    	
    	
    	
    	<div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">服务明细</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <!--
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                   <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div> -->
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>服务</th>
                  <th>价格</th>
                  <th>操作</th>
                </tr>
                <?php foreach ($quotationDetailList as $quotationDetail) {?>
                <tr>
                  <td><?= $quotationDetail->product->name?></td>
                  <td><?= $quotationDetail->price ?></td>
                  <td><?= Html::a(Yii::t('app', 'Delete'), ['delete-quotation-detail', 'id' => $quotationDetail->id], [
	            'class' => '',
	            'data' => [
	                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
	                'method' => 'post',
	            ],
	        ]) ?></td>
                </tr>
                <?php }?>
              </table>
            </div>
            <!-- /.box-body -->
    </div>
          <!-- /.box -->
    
    <div class="box">
	    <div class="box-footer">
	    	<?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	        <?php /* echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
	                'method' => 'post',
	            ],
	        ])*/ ?>
	         <?= Html::a('添加订单咨询明细',['create-quotation-detail', 'quotation_id'=>$model->id],['class' => 'btn btn-success']);?>
	    </div>
    
    </div>

</div>
