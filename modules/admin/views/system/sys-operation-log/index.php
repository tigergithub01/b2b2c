<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\Module;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\SysOperationLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Sys Operation Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-operation-log-index">
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
//             'id',
//             'user_id',
//         	[
//         		'attribute'=>'user.user_id',
// 			],
        	'user.user_id',
            //'module_id',
            'module.name',
            'op_date',
            'op_ip_addr',
             //'op_browser_type',
             //'op_url:url',
             //'op_desc:ntext',
            // 'op_method',
            // 'op_referrer',
            // 'op_module',
             'op_controller',
             'op_action',
        	'op_desc:ntext',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

