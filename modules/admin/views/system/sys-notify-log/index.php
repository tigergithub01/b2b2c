<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\SysNotifyLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sys Notify Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-notify-log-index">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

		<div class="box box-primary">
		    <div class="box-header with-border">
		     	<h3 class="box-title"><?= Html::encode($this->title) ?></h3>
		    </div>
		    <div class="box-body table-responsive no-padding">
<?php Pjax::begin(); ?>    <?= app\modules\admin\components\AppGridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'app\modules\admin\components\AppSerialColumn'],
            'id',
            // 'notify_id',
            //'notify.title',
        	[
        		'format'=>'raw',
        		'attribute'=>'notify.title',
        		'value' => function($model){
        			//var_dump($model);
        			return Html::a($model->notify->title, ['system/sys-notify/view', 'id' => $model->notify_id], ['title' => $model->notify->title]);
        		}
        		],
            // 'vip_id',
            'vip.vip_name',
            'create_date',
            'read_date',
            // 'expiration_time',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

