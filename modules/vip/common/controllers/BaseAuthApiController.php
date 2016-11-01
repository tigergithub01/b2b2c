<?php
namespace app\modules\vip\common\controllers;

use Yii;
use yii\web\Controller;
use app\modules\vip\common\filters\VipAuthBehavior;
use app\modules\vip\common\filters\VipAuthFilter;


/**
 * 会员中心
 * @author Tiger-guo
 *
 */
class BaseAuthApiController extends BaseAuthController
{
	
	
	public $layout= false;
	
	
}