<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\Module;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\RefundSheetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Refund Sheets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-sheet-index">
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
            // 'id',
            // 'sheet_type_id',
            // 'refund_apply_id',
        	'refundApply.code',
            'code',
            //'order_id',
            'order.code',
            // 'return_id',
            // 'return.code',
            // 'user_id',
            'user.user_id',
             'sheet_date',
            // 'need_return_amt',
            // 'return_amt',
            // 'memo',
            // 'status',
        	// 'status0.param_val',
            // 'vip_id',
            'vip.vip_name',
            // 'merchant_id',
            //'merchant.vip_name',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}</span>',
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

