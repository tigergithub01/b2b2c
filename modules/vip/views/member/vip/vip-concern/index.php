<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\vip\Module;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\VipConcernSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Vip Concerns');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-concern-index">
    <?php  /* echo $this->render('_search', ['model' => $searchModel, 
    		'vipList' => $vipList,
    		'merchantList' => $merchantList,
    ]);*/ ?>

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
            //'vip_id',
        	// 'vip.vip_id',
            //'ref_vip_id',
        	// 'refVip.vip_id',
        	'refVip.vip_name',
            'concern_date',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{delete}</span>',
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

