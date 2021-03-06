<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\vip\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Vip */

$this->title = /* $model->vip_id */Module::t('app', '个人资料');
// $this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Vips'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-view">
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
             'vip_id',
            // 'merchant_flag',
            //'merchantFlag.param_val',
        	[
        		'attribute' => 'vip_name',
        		'label' => '昵称',
        	],
            'last_login_date',
            //'password',
            //'parent_id',
            //'mobile',
            // 'mobile_verify_flag',
            //'mobileVerifyFlag.param_val',
            //'email:email',
            //'email_verify_flag:email',
            //'emailVerifyFlag.param_val',
            //'status',
            // 'status0.param_val',
            'register_date',
            //'rank_id',
            //'rank.name',
            // 'audit_status',
            'auditStatus.param_val',
            //'audit_user_id',
            //'auditUser.user_id',
            //'audit_date',
            //'audit_memo',
            // 'vip_type_id',
            //'vipType.name',
            //'sex',
            'sex0.param_val',
//             'nick_name',
            'wedding_date',
            'birthday',
            // 'img_url:url',
            // 'thumb_url:url',
            // 'img_original',
        		[
        		'attribute' => 'img_url',
        		'format' =>'raw',
        		//'value'=>Html::a($model->img_url,Yii::$app->request->hostInfo . '/' . $model->img_url,['target'=>'_blank',]),
        		'value'=>empty($model->img_url)?'':'<a class="fancybox" href="'.Yii::$app->request->hostInfo . '/' . $model->img_url. '"><img src="'.Yii::$app->request->hostInfo . '/' . $model->thumb_url.'" width="200" height="200"></a>'
        		],
        		/* [
        				'attribute' => 'thumb_url',
        				'format' =>'raw',
        				'value'=>Html::a($model->thumb_url,Yii::$app->request->hostInfo . '/' . $model->thumb_url,['target'=>'_blank',]),
        		],
        		[
        				'attribute' => 'img_original',
        				'format' =>'raw',
        				'value'=>Html::a($model->img_original,Yii::$app->request->hostInfo . '/' . $model->img_original,['target'=>'_blank',]),
        		], */
		        		
		        ],
		    ]) ?>
    	</div>
    
	    <div class="box-footer">
	    	<?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
