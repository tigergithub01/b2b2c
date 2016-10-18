<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\Module;

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
		            'id',
            'name',
            // 'type_id',
            'type.name',
            // 'vip_id',
            'vip.vip_id',
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
        		'value'=>Html::img(Yii::$app->request->hostInfo . '/' . $model->cover_img_url,['width'=>220,'height'=>220]),
        		],
        		[
        		'attribute' => 'cover_img_url',
        		'format' =>'raw',
        		'value'=>Html::a($model->cover_img_url,Yii::$app->request->hostInfo . '/' . $model->cover_img_url,['target'=>'_blank',]),
        		],
        		[
        				'attribute' => 'cover_thumb_url',
        				'format' =>'raw',
        				'value'=>Html::a($model->cover_thumb_url,Yii::$app->request->hostInfo . '/' . $model->cover_thumb_url,['target'=>'_blank',]),
        		],
        		[
        				'attribute' => 'cover_img_original',
        				'format' =>'raw',
        				'value'=>Html::a($model->cover_img_original,Yii::$app->request->hostInfo . '/' . $model->cover_img_original,['target'=>'_blank',]),
        		],
		        		
            // 'is_hot',
            'isHot.param_val',
            //'case_flag',
            //'caseFlag.param_val',
            'market_price',
            'sale_price',
		        ],
		    ]) ?>
    	</div>
    	
    	<div class="box">
            <div class="box-header">
              <h3 class="box-title">案例相册</h3>

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
                  <th></th>
                  <th>ID</th>
                  <th>User</th>
                  <th>Date</th>
                  <th>操作</th>
                </tr>
                <?php foreach ($model->vipCasePhotos as $vipCasePhoto) {?>
                <tr>
                  <td><?php echo Html::img(Yii::$app->request->hostInfo . '/' . $vipCasePhoto->img_url,['width'=>50, 'height'=>50])?></td>
                  <td><?= $vipCasePhoto->img_url ?></td>
                  <td><?= $vipCasePhoto->thumb_url ?></td>
                  <td><?= $vipCasePhoto->img_original ?></td>
                  <td>{delete}</td>
                </tr>
                <?php }?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    
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
	    </div>
    
    </div>

</div>
