<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\ProductComment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Product Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-comment-view">
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
            // 'product_id',
            'product.name',
		    'package.name',
		    'order.code',
            // 'vip_id',
            'vip.vip_id',
            //'cmt_rank_id',
            'cmtRank.param_val',
            'content',
            'comment_date',
            'ip_addr',
            // 'status',
            'status0.param_val',
            //'parent_id',
		        ],
		    ]) ?>
    	</div>
    
	    
    
    </div>
    
    
    <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">图片</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                   <div class="input-group-btn">
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->        
            
            
            
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th></th>
                  <th>操作</th>
                </tr>
                <?php foreach ($model->productCommentPhotos as $productCommentPhoto) {?>
                <tr>
                  <td>
                  <a class="fancybox" data-fancybox-group="gallery" href="<?php echo Yii::$app->request->hostInfo . '/' . $productCommentPhoto->img_url?>"><img width="200" height="200" src="<?php echo Yii::$app->request->hostInfo . '/' . $productCommentPhoto->thumb_url?>"></a>
                  <td valign="middle">
                  	<?= Html::a(Yii::t('app', 'Delete'), ['delete-product-comment-photo', 'id' => $productCommentPhoto->id], [
			            'class' => '',
			            'data' => [
			                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
			                'method' => 'post',
			            ],
			        ]) ?>
                  </td>
                </tr>
                <?php }?>
              </table>
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
