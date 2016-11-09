<?php
namespace app\modules\vip\common\controllers;

use app\modules\vip\common\filters\VipAuthApiFilter;
use app\modules\vip\common\filters\VipLogFilter;

/**
 * 会员中心 api
 * @author Tiger-guo
 *
 */
class BaseAuthApiController extends BaseApiController
{
	
	
	public $layout= false;
	
	public function behaviors()
	{
		return array_merge([
				VipAuthApiFilter::className(),
				VipLogFilter::className(),
				/* 'authBehavior' => [
				 'class' => VipAuthBehavior::className(),
				], */
		]);
	}
	
}