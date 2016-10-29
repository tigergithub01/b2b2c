<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\merchant\Module;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\RefundSheetApplySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Refund Sheet Applies');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-sheet-apply-index">
    <?php  echo $this->render('_search', ['model' => $searchModel, 
    		'vipList' => $vipList,
    		'refundApplyStatusList' => $refundApplyStatusList,
    		'soSheetList' => $soSheetList,
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
            // 'status',
            'apply_date',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}</span>',
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

