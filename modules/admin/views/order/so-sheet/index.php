<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\Module;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\SoSheetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'So Sheets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-sheet-index">
    <?php  echo $this->render('_search', ['model' => $searchModel, 
    		'vipList' => $vipList,
    		'proviceList' => $proviceList,
    		'cityList' => $cityList,
    		'districtList' => $districtList,
    		'countryList' => $countryList,
    		'deliveryStatusList' => $deliveryStatusList,
    		'invoiceTypeList' => $invoiceTypeList,
    		'orderStatusList' => $orderStatusList,
    		'payStatusList' => $payStatusList,
    		'payTypeList' => $payTypeList,
    		'deliveryTypeList' => $deliveryTypeList,
    		'pickUpPointList' => $pickUpPointList,
    		'sheetTypeList' => $sheetTypeList,
    		'serviceStyleList' => $serviceStyleList,
    		'relatedServiceList' => $relatedServiceList,
    ]); ?>

		<div class="box box-primary">
		    <div class="box-header with-border">
		     	<h3 class="box-title"><?= Html::encode($this->title) ?></h3>
		    </div>
		    <div class="box-body table-responsive no-padding">
<?php Pjax::begin(); ?>    <?= app\modules\admin\components\AppGridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'app\modules\admin\components\AppSerialColumn'],
            // 'id',
            // 'sheet_type_id',
            'sheetType.name',
            'code',
            // 'vip_id',
            // 'vip.vip_id',
            'vip.vip_name', 
        	'order_date',
        	'goods_amt',
        	'paid_amt',
            'order_amt',
            // 'order_quantity',
            
            // 'deliver_fee',
            // 'delivery_date',
            // 'delivery_type',
            // 'pay_type_id',
            // 'pay_date',
            // 'delivery_no',
            // 'pick_point_id',
           
            // 'integral',
            // 'integral_money',
            // 'coupon',
            // 'discount',
            // 'return_amt',
            // 'return_date',
            // 'memo',
            // 'order_status',
            'orderStatus.param_val',
            // 'delivery_status',
            // 'pay_status',
        	'payStatus.param_val',
            // 'consignee',
            // 'country_id',
            // 'province_id',
            // 'city_id',
            // 'district_id',
            // 'mobile',
            // 'detail_address',
            // 'invoice_type',
            // 'invoice_header',
            // 'service_date',
            // 'budget_amount',
            // 'related_service',
            // 'service_style',
            // 'related_case_id',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

