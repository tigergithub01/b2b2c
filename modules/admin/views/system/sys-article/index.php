<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\Module;
use app\models\b2b2c\SysParameter;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\SysArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Sys Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-article-index">
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
//             'type_id',
            'title',
//             'code',
            'issue_date',
            // 'content:ntext',
            // 'issue_user_id',
            // 'is_show',
            // 'is_sys_flag',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
			'buttons' => [
					'delete' => function ($url, $model, $key) {
						return ($model->is_sys_flag==SysParameter::no)?Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
								['title' => '删除',
										'data' => [
												'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
												'method' => 'post',
										],
								] ):'';
					},
			],
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

