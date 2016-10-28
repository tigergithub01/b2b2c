<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\merchant\Module;
use app\models\b2b2c\SysParameter;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\ActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Activities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index">
    <?php  echo $this->render('_search', ['model' => $searchModel,
    		'activityTypeList' => $activityTypeList,
    		'vipList' => $vipList,
    		'sysUserList' => $sysUserList,
    		'yesNoList' => $yesNoList,
    		'auditStatList' => $auditStatList,
    		]); ?>

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
            'name',
            // 'activity_type',
            //'activityType.name',
            // 'activity_scope',
            //'actScopes.param_val',
            // 'start_time',
            // 'end_date',
            // 'description',
             'package_price',
            // 'deposit_amount',
            // 'buy_limit_num',
            // 'vip_id',
            // 'img_url:url',
            // 'thumb_url:url',
            // 'img_original',
            // 'audit_status',
           'auditStatus.param_val',
            // 'audit_user_id',
            // 'audit_date',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}</span>',
			'buttons' => [
				'update' => function ($url, $model, $key) {
					return (($model->audit_status==SysParameter::audit_need_submit || $model->audit_status==SysParameter::audit_rejected)?Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, ['title' => '修改密码'] ):'');
				},
				],
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

