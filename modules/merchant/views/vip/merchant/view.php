<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\merchant\Module;
use app\models\b2b2c\SysParameter;

/* @var $this yii\web\View */
/* @var $model app\models\b2b2c\Vip */

$this->title = $model->vip_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vip-view">
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
		
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">基础信息</a></li>
              
              <?php if($vipOrganization){?>
              <li><a href="#tab_2" data-toggle="tab">营业信息</a></li>
              <?php }?>
              <?php if($vipExtend){?>
              <li><a href="#tab_3" data-toggle="tab">身份信息</a></li>
              <?php }?>
              <?php if($product){?>
              <li><a href="#tab_4" data-toggle="tab">服务定价</a></li>
              <?php }?>
            </ul>
            
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
              		<div class="box-body">
					    <?= DetailView::widget([
					        'model' => $model,
					        'attributes' => [
					            // 'id',
			            'vip_id',
			            // 'merchant_flag',
			            // 'merchantFlag.param_val',
			            'vip_name',
			            'last_login_date',
			            // 'password',
			            // 'parent_id',
			            // 'mobile',
			            // 'mobile_verify_flag',
			            // 'mobileVerifyFlag.param_val',
			            // 'email:email',
			            //'email_verify_flag:email',
			            // 'emailVerifyFlag.param_val',
			            //'status',
			            'status0.param_val',
			            'register_date',
			            //'rank_id',
			            //'rank.name',
			            // 'audit_status',
			            'auditStatus.param_val',
			            //'audit_user_id',
			            'auditUser.user_id',
			            'audit_date',
			            'audit_memo',
			            // 'vip_type_id',
			            'vipType.name',
			            //'sex',
			            'sex0.param_val',
			//             'nick_name',
			            // 'wedding_date',
			            // 'birthday',
			            // 'img_url:url',
			            // 'thumb_url:url',
			            // 'img_original',
			        		[
			        		'attribute' => 'img_url',
			        		'format' =>'raw',
			        		'value'=>empty($model->img_url)?'':'<a class="fancybox" href="'.Yii::$app->request->hostInfo . '/' . $model->img_url. '"><img src="'.Yii::$app->request->hostInfo . '/' . $model->thumb_url.'" width="200" height="200"></a>'
			        		],
					        ],
					    ]) ?>
			    	</div>
              </div>
              <!-- /.tab-pane -->
              <?php if(!$model->isNewRecord){?>
              <div class="tab-pane" id="tab_2">
              		<?= DetailView::widget([
		        'model' => $vipOrganization,
		        'attributes' => [
            // 'id',
            // 'name',
            // 'status',
            // 'logo_img_url:url',
            // 'logo_thumb_url:url',
            // 'logo_img_original',
            // 'cover_img_url:url',
            // 'cover_thumb_url:url',
            // 'cover_img_original',
        	[
        		'attribute' => 'cover_img_url',
        		'format' =>'raw',
        		'value'=>empty($vipOrganization->cover_img_url)?'':'<a class="fancybox" href="'.Yii::$app->request->hostInfo . '/' . $vipOrganization->cover_img_url. '"><img src="'.Yii::$app->request->hostInfo . '/' . $vipOrganization->cover_thumb_url.'" width="200" height="200"></a>'
        	],
            // 'vip_id',
            'description',
            //'country_id',
            'country.name',
            //'province_id',
            'province.name',
            //'city_id',
            'city.name',
            // 'audit_status',
            // 'audit_user_id',
            // 'audit_date',
            // 'audit_memo',
            // 'create_date',
            // 'update_date',
            // 'district_id',
            'district.name',
            'address',
		        ],
		    ]) ?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
              <?= DetailView::widget([
		        'model' => $vipExtend,
		        'attributes' => [
		            // 'id',
            // 'vip_id',
            'real_name',
            'id_card_no',
            // 'id_card_img_url:url',
            // 'id_card_thumb_url:url',
            // 'id_card_img_original',
        	[
        		'attribute' => 'id_card_img_url',
        		'format' =>'raw',
        		'value'=>empty($vipExtend->id_card_img_url)?'':'<a class="fancybox" href="'.Yii::$app->request->hostInfo . '/' . $vipExtend->id_card_img_url. '"><img src="'.Yii::$app->request->hostInfo . '/' . $vipExtend->id_card_thumb_url.'" width="200" height="200"></a>'
        	],
            // 'id_back_img_url:url',
            // 'id_back_thumb_url:url',
            // 'id_back_img_original',
        	[
        		'attribute' => 'id_back_img_url',
        		'format' =>'raw',
        		'value'=>empty($vipExtend->id_back_img_url)?'':'<a class="fancybox" href="'.Yii::$app->request->hostInfo . '/' . $vipExtend->id_back_img_url. '"><img src="'.Yii::$app->request->hostInfo . '/' . $vipExtend->id_back_thumb_url.'" width="200" height="200"></a>'
        				],
            // 'bl_img_url:url',
            // 'bl_thumb_url:url',
            // 'bl_img_original',
            'bank_account',
            'bank_name',
            'bank_number',
            'bank_addr',
            // 'audit_status',
            // 'audit_user_id',
            // 'audit_date',
            // 'audit_memo',
            // 'create_date',
            // 'update_date',
		        ],
		    ]) ?>
              
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4">
              	<?= DetailView::widget([
		        'model' => $product,
		        'attributes' => [
		            // 'id',
            'market_price',
            'sale_price',
            'deposit_amount',
		        ],
		    ]) ?>
              </div>
              <!-- /.tab-pane -->
              <?php }?>
            </div>
            <!-- /.tab-content -->
          </div>
          

		
    
	    <div class="box-footer">
	    
	    	<?php if ($model->audit_status==SysParameter::audit_need_approve || $model->audit_status==SysParameter::audit_rejected) {?>
	    		<?= Html::a(Yii::t('app', 'Update'), ['update'], ['class' => 'btn btn-primary']) ?>
	    	<?php }?>
	    	
	    	<?php if ($model->audit_status==SysParameter::audit_need_approve || $model->audit_status==SysParameter::audit_rejected) {?>
	        <?= Html::a(Yii::t('app', '提交审核'), ['submit', 'id' => $model->id], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => Yii::t('app', '是否提交审核?'),
	                'method' => 'post',
	            ],
	        ]) ?>
	        <?php }?>
	    </div>
    
    </div>

</div>
