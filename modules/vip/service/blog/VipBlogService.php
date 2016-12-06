<?php

namespace app\modules\vip\service\blog;

use app\common\utils\CommonUtils;
use app\common\utils\UrlUtils;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\Vip;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\VipBlog;
use app\modules\vip\service\vip\VipCollectService;
use app\models\b2b2c\VipBlogCmt;
use app\models\b2b2c\VipCollect;

class VipBlogService {
	
	/**
	 * 格式化model
	 *
	 * @param unknown $model        	
	 */
	public function getVipBlogModelArray($model) {
		$data = ArrayHelper::toArray ( $model, [
				VipBlog::className () => array_merge ( CommonUtils::getModelFields ( new VipBlog () ), [ 
						'collect_count' => function ($value) {
							$vipCollectService = new VipCollectService ();
							$count = $vipCollectService->getVipCollectCount ( VipCollect::collect_blog, $value->id );
							return $count;
						},
						'reply_count' => function ($value) {
							$count = VipBlogCmt::find ()->where ( [ 
									'blog_id' => $value->id,
									'status' => SysParameter::yes 
							] )->count ();
							return $count;
						},
						'vip_name' => function ($value) {
							return (empty ( $value->vip ) ? '' : $value->vip->vip_name);
						},
						'thumb_url' => function ($value) {
							return (empty ( $value->vip ) ? '' : UrlUtils::formatUrl ( $value->vip->thumb_url ));
						},
						'blog_type_name' => function ($value) {
							return (empty ( $value->blogType ) ? '' : $value->blogType->name);
						},
						'vipBlogPhotos' => function ($value) {
							$vipBlogPhotos = $value->vipBlogPhotos;
							if ($vipBlogPhotos) {
								foreach ( $vipBlogPhotos as $vipBlogPhoto ) {
									$vipBlogPhoto->img_url = UrlUtils::formatUrl ( $vipBlogPhoto ['img_url'] );
									$vipBlogPhoto->img_original = UrlUtils::formatUrl ( $vipBlogPhoto ['img_original'] );
									$vipBlogPhoto->thumb_url = UrlUtils::formatUrl ( $vipBlogPhoto ['thumb_url'] );
									;
								}
							}
							return $vipBlogPhotos;
						} 
				] ) 
		] );
		
		return $data;
	}
}