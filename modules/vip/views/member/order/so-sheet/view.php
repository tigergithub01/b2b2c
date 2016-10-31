<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\vip\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SoSheet */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'So Sheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-sheet-view">
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
            //'sheet_type_id',
            'sheetType.name',
            'code',
            //'vip_id',
            'vip.vip_name',
		    'goods_amt',
		    'paid_amt',
            'order_amt',
            // 'order_quantity',
            
            // 'deliver_fee',
            'order_date',
            // 'delivery_date',
            //'delivery_type',
            // 'deliveryType.name',
            //'pay_type_id',
		    'payType.name',
            'pay_date',
            // 'delivery_no',
            //'pick_point_id',
            // 'pickPoint.name',
            
            // 'integral',
            // 'integral_money',
            // 'coupon',
            // 'discount',
            // 'return_amt',
            // 'return_date',
            'memo',
            'message',
            //'order_status',
		    'orderStatus.param_val',
            //'delivery_status',
            // 'deliveryStatus.param_val',
            //'pay_status',
            'payStatus.param_val',
            'consignee',
            //'country_id',
            // 'country.name',
            //'province_id',
            // 'province.name',
            //'city_id',
            // 'city.name',
            //'district_id',
		    // 'district.name',
            'mobile',
            // 'detail_address',
            //'invoice_type',
            // 'invoiceType.param_val',
            // 'invoice_header',
            'service_date',
            'budget_amount',
            //'related_service',
            'related_service_names',
            //'service_style',
            'serviceStyle.param_val',
            // 'related_case_id',
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
                  <!-- <th>操作</th> -->
                </tr>
                <?php foreach ($soSheetDetailList as $soSheetDetail) {?>
                <tr>
                  <td><?= ($soSheetDetail->package)?$soSheetDetail->package->name.'(团体服务)':$soSheetDetail->product->name?></td>
                  <td><?= $soSheetDetail->price ?></td>
                  <!-- <td> --><?php /* echo Html::a(Yii::t('app', 'Delete'), ['delete-so-sheet-detail', 'id' => $soSheetDetail->id], [
	            'class' => '',
	            'data' => [
	                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
	                'method' => 'post',
	            ],
	        ])*/ ?><!-- </td> -->
                </tr>
                <?php }?>
              </table>
            </div>
            <!-- /.box-body -->
    </div>
          <!-- /.box -->
          
          <div class="box">
    	<div class="box-footer">
	    	<?php // echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	        <?php /*echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
	                'method' => 'post',
	            ],
	        ])*/ ?>
	        <?php // echo Html::a('添加订单明细',['create-so-sheet-detail', 'order_id'=>$model->id],['class' => 'btn btn-success']);?>
	        
	        <?php echo Html::a(Module::t('app', 'Create Refund Sheet Apply'), ['member/order/refund-sheet-apply/create','order_id' => $model->id ], ['class' => 'btn btn-success']) ?>
	    </div>
	</div> 

</div>
