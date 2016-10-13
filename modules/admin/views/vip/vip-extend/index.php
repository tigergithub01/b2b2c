<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\VipExtendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vip Extends');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-extend-index">
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
            'id',
            'vip_id',
            'real_name',
            'id_card_no',
            'id_card_img_url:url',
            // 'id_card_thumb_url:url',
            // 'id_card_img_original',
            // 'id_back_img_url:url',
            // 'id_back_thumb_url:url',
            // 'id_back_img_original',
            // 'bl_img_url:url',
            // 'bl_thumb_url:url',
            // 'bl_img_original',
            // 'bank_account',
            // 'bank_name',
            // 'bank_number',
            // 'bank_addr',
            // 'audit_status',
            // 'audit_user_id',
            // 'audit_date',
            // 'audit_memo',
            // 'create_date',
            // 'update_date',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

