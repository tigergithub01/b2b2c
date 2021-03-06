<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\Module;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\VipBlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Vip Blogs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-blog-index">
    <?php  echo $this->render('_search', [
    		'model' => $searchModel,
    		'vipList' => $vipList,
    		'yesNoList' => $yesNoList,
    		'blogFlagList' => $blogFlagList,
    		'auditStatusList' => $auditStatusList,
    		'vipBlogTypeList' => $vipBlogTypeList,
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
            //'blog_type',
            'blogType.name',
            //'blog_flag',
            'blogFlag.param_val',
            //'vip_id',
            //'vip.vip_id',
        	'vip.vip_name',
            //'content:ntext',
            'create_date',
            // 'update_date',
            // 'audit_user_id',
            // 'audit_status',
        	'auditStatus.param_val',
            // 'audit_date',
            // 'audit_memo',
            // 'status',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

