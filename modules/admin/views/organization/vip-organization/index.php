<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\VipOrganizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vip Organizations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-organization-index">
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
            'name',
            'status',
            'logo_img_url:url',
            'logo_thumb_url:url',
            // 'logo_ilmg_original',
            // 'cover_img_url:url',
            // 'cover_thumb_url:url',
            // 'cover_img_original',
            // 'vip_id',
            // 'description',
            // 'country_id',
            // 'province_id',
            // 'city_id',

            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

