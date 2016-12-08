<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\RefundSheetApply;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '首页');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-default-index">
	<div class="row">
        <div class="col-md-6">
		    <div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title" style="visibility: visible;">待审核商户（<?= Html::a($model['need_approve_merchant_count'],['vip/merchant/index','VipSearch[audit_status]'=>SysParameter::audit_need_approve])?>）</h3>
					<div class="box-tools pull-right">
					</div>
				</div>
				
			</div>
		</div>	
		
		<div class="col-md-6">	
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title" style="visibility: visible;">待审核案例（<?= Html::a($model['need_approve_case_count'],['vip/vip-case/index','VipCaseSearch[audit_status]'=>SysParameter::audit_need_approve])?>）</h3>
					<div class="box-tools pull-right">
					</div>
				</div>
				
			</div>
		</div>
		
		<div class="col-md-6">	
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title" style="visibility: visible;">待审核团体服务（<?= Html::a($model['need_approve_act_count'],['basic/activity/index','ActivitySearch[audit_status]'=>SysParameter::audit_need_approve])?>）</h3>
					<div class="box-tools pull-right">
					</div>
				</div>
				
			</div>
		</div>
		
		
		<div class="col-md-6">	
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title" style="visibility: visible;">待处理退款申请（<?= Html::a($model['need_approve_refund_apply_count'],['order/refund-sheet-apply/index','RefundSheetApplySearch[status]'=>RefundSheetApply::status_need_approve])?>）</h3>
					<div class="box-tools pull-right">
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
