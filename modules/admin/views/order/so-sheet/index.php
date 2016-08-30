<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\SoSheetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'So Sheets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-sheet-index">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

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
			[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
            ],
            'id',
            'sheet_type_id',
            'code',
            'vip_id',
            'order_amt',
            // 'order_quantity',
            // 'goods_amt',
            // 'deliver_fee',
            // 'order_date',
            // 'delivery_date',
            // 'delivery_type',
            // 'pay_type_id',
            // 'pay_date',
            // 'delivery_no',
            // 'pick_point_id',
            // 'paid_amt',
            // 'integral',
            // 'integral_money',
            // 'coupon',
            // 'discount',
            // 'return_amt',
            // 'return_date',
            // 'memo',
            // 'message',
            // 'order_status',
            // 'delivery_status',
            // 'pay_status',
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

            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

