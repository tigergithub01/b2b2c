<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\Module;

/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\SysAdInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Sys Ad Infos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-ad-info-index">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

		<div class="box box-primary">
		    <div class="box-header with-border">
		     	<h3 class="box-title"><?= Html::encode($this->title) ?></h3>
		    </div>
		    <div class="box-body table-responsive no-padding">
    <?php //Pjax::begin(); ?><?= app\modules\admin\components\AppGridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'app\modules\admin\components\AppSerialColumn'],
            'id',
            //'img_url:url',
//             'thumb_url:url',
//             'img_original',
        		[
		        		'attribute' => 'img_url',
		        		'format' =>'raw',
		        		'value'=>function($model){return Html::a($model->img_url,Yii::$app->request->hostInfo . '/' . $model->img_url,['target'=>'_blank',]);},
        		],
        		[
        				'attribute' => 'thumb_url',
        				'format' =>'raw',
        				'value'=>function($model){return Html::a($model->thumb_url,Yii::$app->request->hostInfo . '/' . $model->thumb_url,['target'=>'_blank',]);},
        		],
        		[
        				'attribute' => 'img_original',
        				'format' =>'raw',
        				'value'=>function($model){return Html::a($model->img_original,Yii::$app->request->hostInfo . '/' . $model->img_original,['target'=>'_blank',]);},
        		],
            'sequence_id',
            // 'redirect_url:url',
            // 'description',
            // 'width',
            // 'height',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
        ],
            
        ],
    ]); ?>
	<?php //Pjax::end(); ?>	</div>
	</div>
</div>

