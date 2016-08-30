<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\VipOrgCaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vip Org Cases');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-org-case-index">
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
            'type_id',
            'organization_id',
            'content:ntext',
            // 'create_date',
            // 'update_date',
            // 'status',
            // 'audit_status',
            // 'audit_user_id',
            // 'audit_date',
            // 'cover_img_url:url',
            // 'cover_thumb_url:url',
            // 'cover_img_original',

            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

