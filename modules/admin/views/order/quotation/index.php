<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\Module;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\QuotationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Quotations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-index">
    <?php  echo $this->render('_search', ['model' => $searchModel,
    		'vipList' => $vipList,
    		'merchantList' => $merchantList,
    		'serviceStyleList' => $serviceStyleList,
    		'relatedServiceList' => $relatedServiceList,
    		'statusList' => $statusList,
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
            'code',
            //'vip_id',
            'vip.vip_name',
            'order_amt',
            'deposit_amount',
            'create_date',
            // 'update_date',
            // 'memo',
            // 'status',
            'status0.param_val',
             'consignee',
             'mobile',
             'service_date:date',
            // 'budget_amount',
            // 'related_service',
            // 'service_style',
            // 'merchant_id',
            'merchant.vip_name',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

