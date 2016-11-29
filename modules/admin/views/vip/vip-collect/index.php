<?php

use app\modules\admin\Module;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\VipCollectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Vip Collects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-collect-index">
    <?php  echo $this->render('_search', ['model' => $searchModel,
    		'vipList' => $vipList,
    		'merchantList' => $merchantList,
    		'productList' => $productList,
    		'vipCaseList' => $vipCaseList,
    		'activityList' => $activityList,
    		'collectTypeList' => $collectTypeList,
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
            'id',
            //'vip_id',
            'vip.vip_id',
            //'product_id',
            'product.name',
            //'package_id',
            'package.name',
            //'case_id',
            'case.name',
        	//ref_vip_id
        	'refVip.vip_name',
        	//collect_type
        	'collectType.param_val',
            // 'blog_id',
             'collect_date',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

