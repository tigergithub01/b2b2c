<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Products'), 'url' => ['index']];
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
            // 'type_id',
            // 'brand_id',
            'type.name',
            'brand.name',
            'market_price',
            'sale_price',
            'deposit_amount',
            'description:ntext',
//             'is_on_sale',
//             'is_hot',
//             'audit_status',
			'isOnSale.param_val',
		    'isHot.param_val',
		    'auditStatus.param_val',
            'audit_user_id',
            'audit_date',
            'stock_quantity',
            'safety_quantity',
            // 'can_return_flag',
            'canReturnFlag.param_val',
            'return_days',
            'return_desc:ntext',
            'cost_price',
            // 'vip_id',
            'vip.vip_name',
            'keywords',
            // is_free_shipping',
		    'isFreeShipping.param_val',
            'give_integral',
            'rank_integral',
            'integral',
            'relative_module',
            'bonus',
            'product_weight',
            'product_weight_unit',
            'product_group_id',
        	[
        		'attribute' => 'img_url',
        		'format' =>'raw',
        		'value'=>empty($model->img_url)?'':'<a class="fancybox" href="'.Yii::$app->request->hostInfo . '/' . $model->img_url. '"><img src="'.Yii::$app->request->hostInfo . '/' . $model->thumb_url.'" width="200" height="200"></a>'
        	],
//             'img_url:url',
//             'thumb_url:url',
//             'img_original',
		        ],
		    ]) ?>
    	</div>
    </div>
    
    <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">案例相册</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                   <div class="input-group-btn">
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->        
            
            <div class="box-body table-responsive no-padding">
                <?php foreach ($model->productGalleries as $vipCasePhoto) {?>
                  	<?php if (strchr(strtolower($vipCasePhoto->img_url), 'mp4')=='mp4'){ ?>
                  		 <video src="<?php echo Yii::$app->request->hostInfo . '/' . $vipCasePhoto->img_url?>" controls="controls">
						您的浏览器不支持 video 标签。
						</video>
                    <?php }else {?>
	                  	<a class="fancybox gallery" data-fancybox-group="gallery" href="<?php echo Yii::$app->request->hostInfo . '/' . $vipCasePhoto->img_url?>"><img width="200" height="200" src="<?php echo Yii::$app->request->hostInfo . '/' . $vipCasePhoto->thumb_url?>"></a>
					<?php }?>
                <?php }?>
            </div>
            <!-- /.box-body -->
    </div>
          <!-- /.box -->
    
    <div class="box"> 
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
