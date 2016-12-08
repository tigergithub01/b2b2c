<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\Module;
use app\models\b2b2c\SysParameter;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\VipCase */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vip Cases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-case-view">
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
            'name',
            // 'type_id',
            'type.name',
            // 'vip_id',
            'vip.vip_name',
            'content:ntext',
            'create_date',
            'update_date',
            // 'status',
            'status0.param_val',
            // 'audit_status',
            'auditStatus.param_val',
            // 'audit_user_id',
            'auditUser.user_id',
            'audit_date',
            'audit_memo',
            // 'cover_img_url:url',
            // 'cover_thumb_url:url',
            // 'cover_img_original',
		        		[
		        		'attribute' => 'cover_img_url',
		        		'format' =>'raw',
		        		'value'=>empty($model->cover_img_url)?'':'<a class="fancybox" href="'.Yii::$app->request->hostInfo . '/' . $model->cover_img_url. '"><img src="'.Yii::$app->request->hostInfo . '/' . $model->cover_thumb_url.'" width="200" height="200"></a>'
		        				],
		        		
            // 'is_hot',
            'isHot.param_val',
            //'case_flag',
            //'caseFlag.param_val',
            'service_date:date',
		    'address',
            //'market_price:decimal',
		    'market_price',
            'sale_price',
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
              <table class="table table-hover">
                <tr>
                  <th></th>
                  <th>操作</th>
                </tr>
                <?php foreach ($model->vipCasePhotos as $vipCasePhoto) {?>
                <tr>
                  <td>
                  <a class="fancybox" data-fancybox-group="gallery" href="<?php echo Yii::$app->request->hostInfo . '/' . $vipCasePhoto->img_url?>"><img width="200" height="200" src="<?php echo Yii::$app->request->hostInfo . '/' . $vipCasePhoto->thumb_url?>"></a>
                  <td valign="middle">
                  	<?= Html::a(Yii::t('app', 'Delete'), ['delete-vip-case-photo', 'id' => $vipCasePhoto->id], [
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
	    	<?= Html::a(Module::t('app', 'Create Vip Case'), ['create'], ['class' => 'btn btn-success']) ?>
	    	<?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
	                'method' => 'post',
	            ],
	        ]) ?>
	        
	        <?php if($model->audit_status==SysParameter::audit_need_approve) {?>    
		  		 <?php echo  Html::a(Yii::t('app', 'approve'), ['approve', 'id' => $model->id], [
		            'class' => 'btn btn-primary',
		            'data' => [
		                'confirm' => Yii::t('app', 'Whether to submit?'),
		                'method' => 'post',
		            ],
		        ]) ?>
		        
		        	  
		        <?php echo Html::a(Yii::t('app', 'reject'), ['reject', 'id' => $model->id/* , 'audit_memo' => 'Reject' */], [
		            'class' => 'btn btn-danger',
		            'data' => [
		                'confirm' => Yii::t('app', 'Whether to submit?'),
		                'method' => 'post',
		            ],
		        ]) ?>
	     	<?php }?>
	     	
	    </div>
	</div>

</div>
