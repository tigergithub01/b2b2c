<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysAdInfo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Ad Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-ad-info-view">
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
            //             'img_url:url',
        		[
        		'attribute' => 'img_url',
        		'format' =>'raw',
        		//         		'value'=>Html::img(Yii::$app->request->hostInfo . '/' . $model->img_url,['width'=>220,'height'=>220]),
        		'value'=>empty($model->img_url)?'':'<a class="fancybox" href="'.Yii::$app->request->hostInfo . '/' . $model->img_url. '"><img src="'.Yii::$app->request->hostInfo . '/' . $model->thumb_url.'" width="200" height="200"></a>'
        				],
//             'thumb_url:url',
//         	[
//         		'attribute' => 'thumb_url',
//         		'label'=>$model->getAttributeLabel('thumb_url'),
//         		'format' =>'raw',
//         		'value'=>Html::img(Yii::$app->request->hostInfo . $model->thumb_url,['width'=>'200','height'=>'200',]),
//         	],
//             'img_original',
            'sequence_id',
            'redirect_url:url',
            'description',
            'width',
            'height',
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
