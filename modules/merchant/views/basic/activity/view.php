<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\merchant\Module;
use app\models\b2b2c\SysParameter;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Activity */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-view">
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
		            //'id',
            'name',
            // 'activity_type',
		    //'activityType.name',
            // 'activity_scope',
		    //'actScopes.param_val',
            //'start_time',
            //'end_date',
            'description:ntext',
		    'market_price', 
            'package_price',
            'deposit_amount',
            //'buy_limit_num',
            // 'vip_id',
            //'vip.vip_name',
            // 'img_url:url',
            // 'thumb_url:url',
            // 'img_original',
        		[
        		'attribute' => 'img_url',
        		'format' =>'raw',
//         		'value'=>Html::img(Yii::$app->request->hostInfo . '/' . $model->img_url,['width'=>220,'height'=>220]),
        		'value'=>empty($model->img_url)?'':'<a class="fancybox" href="'.Yii::$app->request->hostInfo . '/' . $model->img_url. '"><img src="'.Yii::$app->request->hostInfo . '/' . $model->thumb_url.'" width="200" height="200"></a>'
        		],
        		/* [
        				'attribute' => 'img_url',
        				'format' =>'raw',
        				'value'=>Html::a($model->img_url,Yii::$app->request->hostInfo . '/' . $model->img_url,['target'=>'_blank',]),
        		],
        		[
        				'attribute' => 'thumb_url',
        				'format' =>'raw',
        				'value'=>Html::a($model->thumb_url,Yii::$app->request->hostInfo . '/' . $model->thumb_url,['target'=>'_blank',]),
        		],
        		[
        				'attribute' => 'img_original',
        				'format' =>'raw',
        				'value'=>Html::a($model->img_original,Yii::$app->request->hostInfo . '/' . $model->img_original,['target'=>'_blank',]),
        		], */
            // 'audit_status',
            'auditStatus.param_val',
            // 'audit_user_id',
           	//'auditUser.user_id',
            'audit_date',
		    'audit_memo:ntext',
		        ],
		    ]) ?>
    	</div>
    	
    	
    
	    
    
    </div>
    
    <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">团队成员</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <!--
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                   <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div> -->
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>团队成员</th>
                  <th>价格</th>
                  <th>操作</th>
                </tr>
                <?php foreach ($actPackageProducts as $actPackageProduct) {?>
                <tr>
                  <td><?= $actPackageProduct->product->vip->vip_name ?></td>
                  <td><?= $actPackageProduct->package_price ?></td>
                  <td>
                  <?php if($model->audit_status==SysParameter::audit_need_submit || $model->audit_status==SysParameter::audit_rejected) {?>
	                  <?= Html::a(Yii::t('app', 'Delete'), ['delete-act-package-product', 'id' => $actPackageProduct->id], [
				            'class' => '',
				            'data' => [
				                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
				                'method' => 'post',
				            ],
				        ]) ?>
	         	<?php }?>
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
    		<?php if($model->audit_status==SysParameter::audit_need_submit || $model->audit_status==SysParameter::audit_rejected) {?>
	    	<?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	        <?php /* Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
	                'method' => 'post',
	            ],
	        ])*/ ?>
	        <?= Html::a('添加团队成员',['create-act-package-product', 'act_id'=>$model->id],['class' => 'btn btn-success']);?>
	        
	        <?php echo  Html::a(Yii::t('app', 'submit'), ['submit', 'id' => $model->id], [
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
