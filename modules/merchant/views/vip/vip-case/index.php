<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\merchant\Module; 
use app\models\b2b2c\SysParameter;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\VipCaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Vip Cases');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-case-index">
    <?php  echo $this->render('_search', ['model' => $searchModel,
    		'vipCaseTypeList' => $vipCaseTypeList,
    		'yesNoList' => $yesNoList,
    		'auditStatList' => $auditStatList,
    		'caseFlagList' => $caseFlagList,
    		'vipList' => $vipList,
    		'sysUserList' => $sysUserList,
    		
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
            //'type_id',
            // 'type.name',
            //'vip_id',
            // 'vip.vip_id',
        	// 'vip.vip_name',
            'content:ntext',
             'create_date',
            // 'update_date',
            // 'status',
            // 'audit_status',
            'auditStatus.param_val',
            // 'audit_user_id',
            // 'audit_date',
            // 'audit_memo',
            // 'cover_img_url:url',
            // 'cover_thumb_url:url',
            // 'cover_img_original',
            // 'is_hot',
            // 'isHot.param_val',
            // 'case_flag',
            // 'market_price',
            // 'sale_price',
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

