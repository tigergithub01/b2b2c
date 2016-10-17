<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SoSheet */

$this->title = $model->id;
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
		            'id',
            //'sheet_type_id',
            'sheetType.name',
            'code',
            //'vip_id',
            'vip.vip_id',
            'order_amt',
            'order_quantity',
            'goods_amt',
            'deliver_fee',
            'order_date',
            'delivery_date',
            //'delivery_type',
            'deliveryType.name',
            //'pay_type_id',
		    'payType.name',
            'pay_date',
            'delivery_no',
            //'pick_point_id',
            'pickPoint.name',
            'paid_amt',
            'integral',
            'integral_money',
            'coupon',
            'discount',
            'return_amt',
            'return_date',
            'memo',
            'message',
            //'order_status',
		    'orderStatus.param_val',
            //'delivery_status',
            'deliveryStatus.param_val',
            //'pay_status',
            'payStatus.param_val',
            'consignee',
            //'country_id',
            'country.name',
            //'province_id',
            'province.name',
            //'city_id',
            'city.name',
            //'district_id',
		    'district.name',
            'mobile',
            'detail_address',
            //'invoice_type',
            'invoiceType.param_val',
            'invoice_header',
            'service_date',
            'budget_amount',
            //'related_service',
            'related_service_names',
            //'service_style',
            'serviceStyle.param_val',
            'related_case_id',
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
