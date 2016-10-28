<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\merchant\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipBlog */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-blog-view">
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
            // 'blog_type',
            'blogType.name',
            //'blog_flag',
            // 'blogFlag.param_val',
            //'vip_id',
            // 'vip.vip_name',
            'content:ntext',
            'create_date',
            // 'update_date',
            //'audit_user_id',
            // 'auditUser.user_id',
            //'audit_status',
            // 'auditStatus.param_val',
            // 'audit_date',
            // 'audit_memo',
            // 'status',
		    // 'status0.param_val',
		        ],
		    ]) ?>
    	</div>
    
	    
    
    </div>
    
    
    <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">帖子图片</h3>

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
                 <!--  <th>操作</th> -->
                </tr>
                <?php foreach ($model->vipBlogPhotos as $vipBlogPhoto) {?>
                <tr>
                  <td>
                  <a class="fancybox" data-fancybox-group="gallery" href="<?php echo Yii::$app->request->hostInfo . '/' . $vipBlogPhoto->img_url?>"><img width="200" height="200" src="<?php echo Yii::$app->request->hostInfo . '/' . $vipBlogPhoto->thumb_url?>"></a>
                  <td valign="middle">
                  	<?php /* Html::a(Yii::t('app', 'Delete'), ['delete-vip-blog-photo', 'id' => $vipBlogPhoto->id], [
			            'class' => '',
			            'data' => [
			                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
			                'method' => 'post',
			            ],
			        ])*/ ?>
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
	    	<?php // echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	        <?php /* Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
	                'method' => 'post',
	            ],
	        ])*/ ?>
	    </div>
	</div>

</div>
