<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\Module;
use app\models\b2b2c\SysParameter;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysArticle */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-article-view">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title" style="visibility: visible;"><?= Html::encode($this->title) ?></h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool"
					data-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>

		<div class="box-body">
		    <?= DetailView::widget([
		        'model' => $model,
		        'attributes' => [
// 		            'id',
//             'type_id',
            'title',
            'code',
            'issue_date',
//             'content:ntext',
		    'content:html',
//             'issue_user_id',
// 		    ['attribute'=>'issue_user_id','format' =>'raw', 'value'=>$model->issueUser->user_id],
		    'issueUser.user_id',
		    ['attribute'=>'is_show','format' =>'raw', 'value'=>$model->isShow->param_val],
		     
//             'is_show',
//             'is_sys_flag',
// 		     ['attribute'=>'is_sys_flag','format' =>'raw', 'value'=>$model->isSysFlag->param_val],
// 			'isShow.param_val',
		    'isSysFlag.param_val',
		        ],
		    ]) ?>
    	</div>
    
	    <div class="box-footer">
	    	<?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	    	<?php if($model->is_sys_flag===SysParameter::no) {?>
	        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
	                'method' => 'post',
	            ],
	        ]) ?>
	        <?php }?>
	    </div>
    
    </div>

</div>
