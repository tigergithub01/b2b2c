<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
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
            'name',
            'type_id',
            'brand_id',
            'market_price',
            'sale_price',
            'deposit_amount',
            'description:ntext',
            'is_on_sale',
            'is_hot',
            'audit_status',
            'audit_user_id',
            'audit_date',
            'stock_quantity',
            'safety_quantity',
            'can_return_flag',
            'return_days',
            'return_desc:ntext',
            'cost_price',
            'organization_id',
            'keywords',
            'is_free_shipping',
            'give_integral',
            'rank_integral',
            'integral',
            'relative_module',
            'bonus',
            'product_weight',
            'product_weight_unit',
            'product_group_id',
            'img_url:url',
            'thumb_url:url',
            'img_original',
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
