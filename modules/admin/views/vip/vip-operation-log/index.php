<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\Module;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\VipOperationLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Vip Operation Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-operation-log-index">
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
            // 'id',
            // 'vip_id',
            //'vip.vip_id',
        	'vip.vip_name',
            // 'module_id',
            //'module.name',
            'op_date',
            'op_ip_addr',
            'op_browser_type',
            // 'op_phone_model',
            'op_url:url',
            'op_desc:ntext',
            // 'op_os_type',
            // 'op_method',
            // 'op_app_ver',
            // 'op_app_type_id',
            // 'op_module',
            // 'op_controller',
            // 'op_action',
            // 'op_referrer',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

