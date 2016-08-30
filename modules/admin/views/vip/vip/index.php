<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\VipSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vips');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-index">
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
			[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
            ],
            'id',
            'vip_id',
            'vip_name',
            'last_login_date',
            'password',
            // 'parent_id',
            // 'mobile',
            // 'mobile_verify_flag',
            // 'email:email',
            // 'email_verify_flag:email',
            // 'status',
            // 'register_date',
            // 'rank_id',

            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>
