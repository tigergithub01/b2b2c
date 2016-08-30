<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
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
            'code',
            'name',
            'type_id',
            'brand_id',
            // 'market_price',
            // 'sale_price',
            // 'deposit_amount',
            // 'description:ntext',
            // 'is_on_sale',
            // 'is_hot',
            // 'audit_status',
            // 'audit_user_id',
            // 'audit_date',
            // 'stock_quantity',
            // 'safety_quantity',
            // 'can_return_flag',
            // 'return_days',
            // 'return_desc:ntext',
            // 'cost_price',
            // 'organization_id',
            // 'keywords',
            // 'is_free_shipping',
            // 'give_integral',
            // 'rank_integral',
            // 'integral',
            // 'relative_module',
            // 'bonus',
            // 'product_weight',
            // 'product_weight_unit',
            // 'product_group_id',
            // 'img_url:url',
            // 'thumb_url:url',
            // 'img_original',

            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

