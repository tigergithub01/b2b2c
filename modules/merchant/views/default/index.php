<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '首页');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="merchant-default-index">
	<div class="row">
		
		<div class="col-md-6">	
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title" style="visibility: visible;">最新信息</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool"
							data-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				
				<div class="box-body">
				</div>
			</div>
		</div>
		
		<div class="col-md-6">	
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title" style="visibility: visible;">最新订单信息</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool"
							data-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				
				<div class="box-body">
				</div>
			</div>
		</div>
		
		
		<div class="col-md-6">	
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title" style="visibility: visible;">最新退款信息</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool"
							data-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				
				<div class="box-body">
				</div>
			</div>
		</div>
	</div>
</div>
