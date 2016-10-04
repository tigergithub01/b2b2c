<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\Module;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\SysParameter;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\SysUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Sys Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-user-index">
    <?php  echo $this->render('_search', ['model' => $searchModel,'yesNoList'=>$yesNoList]); ?>

		<div class="box box-primary">
		    <div class="box-header with-border">
		     	<h3 class="box-title"><?= Html::encode($this->title) ?></h3>
		    </div>
		    <div class="box-body table-responsive no-padding">
<?php Pjax::begin(); ?>    <?= app\modules\admin\components\AppGridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
        		/* [
        		'class' => 'yii\grid\CheckboxColumn',
        		// you may configure additional properties here
        		], */
            //['class' => 'app\modules\admin\components\AppSerialColumn'],
            'id',
//             'user_id',
        	[
        		'label'=>'用户名',
        		'format'=>'raw',
        		'attribute'=>'user_id',
        		'value' => function($model){
        			//var_dump($model);
        			return Html::a($model->user_id, ['system/sys-user/view', 'id' => $model->id], ['title' => '查看详情']);
        		}
			],
            'user_name',
            //'password',
            //'is_admin',
//             'status',
//             'status0.param_val',
			['attribute'=>'status0.param_val',/* 'label'=>'是否有效1', */],
// 			['attribute' => 'param_val',  'value' => 'status0.param_val' ],
            // 'last_login_date',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}{change-pwd}</span>',
			'buttons' => [
					'change-pwd' => function ($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, ['title' => '修改密码'] );
					},
					'delete' => function ($url, $model, $key) {
						return ($model->is_admin==SysParameter::yes)?Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, 
								['title' => '删除',
								'data' => [
					                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
					                'method' => 'post',
					            ],	
						] ):'';
					},
			],
			'headerOptions' =>['width' => '120']
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

