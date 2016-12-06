<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\Module;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\ProductCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Product Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-comment-index">
    <?php  echo $this->render('_search', ['model' => $searchModel, 'cmtRankList' => $cmtRankList,]); ?>

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
            // 'product_id',
        	'product.name',
        	'package.name',
            // 'vip_id',
        	'vip.vip_name',
            // 'cmt_rank_id',
        	'cmtRank.param_val',
        	'order.code',
            // 'content',
            // 'comment_date',
            // 'ip_addr',
            // 'status',
            // 'parent_id',
        	[
        		'class' => 'app\modules\admin\components\AppActionColumn',
        		'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
        	],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

