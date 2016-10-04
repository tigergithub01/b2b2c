<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\Module;
use app\models\b2b2c\SysParameter;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\SysUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Sys Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-user-view">
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
		            'id',
            'user_id',
            'user_name',
            //'password',
            //'is_admin',
//             'status',
		    'status0.param_val',
            'last_login_date',
		        ],
		    ]) ?>
    	</div>
    
	    <div class="box-footer">
	    	<?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	        <?= $model->is_admin==SysParameter::no?Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
	                'method' => 'post',
	            ],
	        ]):'' ?>
	        <?= Html::a(Module::t('app', 'Change User Pwd'), ['change-pwd', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	    </div>
    
    </div>

</div>
