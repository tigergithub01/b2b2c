<?php

namespace app\modules\vip\service\vip;

use app\models\b2b2c\SysParameter;
use app\models\b2b2c\Vip;
use app\models\b2b2c\VipBlog;
use app\models\b2b2c\VipCase;
use app\models\b2b2c\Activity;
use app\models\b2b2c\ProductComment;
use app\models\b2b2c\Product;
use app\models\b2b2c\VipOrganization;
use app\common\utils\UrlUtils;
use yii\helpers\ArrayHelper;
use app\common\utils\CommonUtils;

class MerchantService {
	
	/**
	 * 格式化model
	 *
	 * @param unknown $model        	
	 */
	public function getMerchantModelArray($model) {
		$data = ArrayHelper::toArray ( $model, [ 
				Vip::className () => array_merge ( CommonUtils::getModelFields ( new Vip () ), [ 
						'vip_type_name' => function ($value) {
							return (empty ( $value->vipType ) ? '' : $value->vipType->name);
						},
						'password' => function ($value) {
							// 密码设置为空
							return null;
						},
						'img_url' => function ($value) {
							return UrlUtils::formatUrl ( $value->img_url );
						},
						'thumb_url' => function ($value) {
							return UrlUtils::formatUrl ( $value->thumb_url );
						},
						'img_original' => function ($value) {
							return UrlUtils::formatUrl ( $value->img_original );
						},
						'vip_org_desc' => function ($value) {
							// 营业描述
							$vip_org_desc = null;
							$vipOrg = VipOrganization::find ()->where ( [ 
									'vip_id' => $value->id 
							] )->one ();
							$vip_org_desc = empty ( $vipOrg ) ? null : $vipOrg->description;
							return $vip_org_desc;
						} 
				] ) 
		] );
		
		return $data;
	}
	
	/**
	 * 审核通过的案例数量
	 *
	 * @param unknown $vip_id        	
	 * @return number|string
	 */
	public function getVipCaseCount($vip_id) {
		return VipCase::find ()->where ( [ 
				'vip_id' => $vip_id,
				'audit_status' => SysParameter::audit_approved 
		] )->count ();
	}
	
	/**
	 * 审核通过的动态数量
	 *
	 * @param unknown $vip_id        	
	 * @return number|string
	 */
	public function getVipBlogCount($vip_id) {
		return VipBlog::find ()->where ( [ 
				'vip_id' => $vip_id,
				'audit_status' => SysParameter::audit_approved,
				'blog_flag' => VipBlog::blog_flag_merchant 
		] )->count ();
	}
	
	/**
	 * 审核通过的团队数量
	 *
	 * @param unknown $vip_id        	
	 * @return number|string
	 */
	public function getActivityCount($vip_id) {
		return Activity::find ()->where ( [ 
				'vip_id' => $vip_id,
				'audit_status' => SysParameter::audit_approved,
				'activity_type' => Activity::act_package 
		] )->count ();
	}
	
	/**
	 * 审核通过的评论数量
	 *
	 * @param unknown $vip_id        	
	 * @return number|string
	 */
	public function getProductCommentCount($vip_id) {
		// $product_id = Product::find()->select(['id'])->where(['vip_id'=>$vip_id])->scalar();
		// return ProductComment::find()->where(['product_id'=>$product_id, 'status'=>SysParameter::yes])->count();
		return ProductComment::find ()->alias ( 'cmt' )->joinWith ( 'product product' )->where ( [ 
				'product.vip_id' => $vip_id,
				'cmt.status' => SysParameter::yes 
		] )->count ();
	}
}