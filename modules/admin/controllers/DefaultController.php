<?php

namespace app\modules\admin\controllers;

use app\modules\admin\common\controllers\BaseAuthController;
use app\modules\admin\service\system\SysUserService;
use Yii;
use yii\web\Controller;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\VipCase;
use app\models\b2b2c\Activity;
use app\models\b2b2c\RefundSheetApply;
use app\models\b2b2c\VipBlog;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends BaseAuthController {
	// public $layout = "main-default";
	public $layout = "main";
	
	/**
	 * Renders the index view for the module
	 *
	 * @return string
	 */
	public function actionIndex() {
		// 待审核商户
		$need_approve_merchant_count = Vip::find ()->where ( [ 
				'merchant_flag' => SysParameter::yes,
				'audit_status' => SysParameter::audit_need_approve 
		] )->count ();
		
		// 待审核案例
		$need_approve_case_count = VipCase::find ()->where ( [ 
				'audit_status' => SysParameter::audit_need_approve 
		] )->count ();
		
		// 待审核团体服务
		$need_approve_act_count = Activity::find ()->where ( [ 
				'audit_status' => SysParameter::audit_need_approve 
		] )->count ();
		
		// 待处理退款申请
		$need_approve_refund_apply_count = RefundSheetApply::find ()->where ( [ 
				'status' => RefundSheetApply::status_need_approve 
		] )->count ();
		
		// 待审核商户动态
		$need_approve_merchant_blog_count = VipBlog::find ()->where ( [
				'blog_flag' => VipBlog::blog_flag_merchant,
				'audit_status' => SysParameter::audit_need_approve
		] )->count ();
		
		// 待审核用户发帖
		$need_approve_vip_blog_count = VipBlog::find ()->where ( [
				'blog_flag' => VipBlog::blog_flag_vip,
				'audit_status' => SysParameter::audit_need_approve
		] )->count ();
		
		// output
		$model ['need_approve_merchant_count'] = $need_approve_merchant_count;
		$model ['need_approve_case_count'] = $need_approve_case_count;
		$model ['need_approve_act_count'] = $need_approve_act_count;
		$model ['need_approve_refund_apply_count'] = $need_approve_refund_apply_count;
		$model ['need_approve_merchant_blog_count'] = $need_approve_merchant_blog_count;
		$model ['need_approve_vip_blog_count'] = $need_approve_vip_blog_count;
		
		return $this->render ( 'index', [ 
				'model' => $model 
		] );
	}
	
	/**
	 * 注销
	 */
	public function actionLogout() {
		$userService = new SysUserService ();
		$userService->logout ();
		
		Yii::$app->getResponse ()->redirect ( "/admin/system/login/index" );
	}
}
