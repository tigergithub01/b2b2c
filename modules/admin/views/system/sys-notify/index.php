<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\Module;
/* @var $this yii\web\View */
/* @var $searchModel app\models\b2b2c\search\SysNotifySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('app', 'Sys Notifies');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-notify-index">
    <?php  echo $this->render('_search', ['model' => $searchModel, 
    		'yesNoList' => $yesNoList,
    		'sendExtendList' => $sendExtendList,
    		'sysUserList' => $sysUserList,
    		'notifyTypeList' => $notifyTypeList,
    		'vipList' => $vipList,
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
            // 'notify_type',
            'notifyType.param_val',
            'title',
            'issue_date',
            'content:ntext',
            // 'vip_id',
            // 'issue_user_id',
            // 'send_extend',
            // 'status',
            // 'is_sent',
            // 'sent_time',
		[
			'class' => 'app\modules\admin\components\AppActionColumn',
            'template' => '<span class=\'tbl_operation\'>{view}{update}{delete}</span>',
        ],
            
        ],
    ]); ?>
<?php Pjax::end(); ?>		</div>
	</div>
</div>

