<?php
namespace app\modules\vip\common\controllers;



use app\modules\vip\common\filters\VipLogFilter;

class BaseApiController extends WebController
{
	//api不需要布局
	public $layout= false;
	
	//不启用csrf
	public $enableCsrfValidation = false;
	
	public function behaviors()
	{
		return array_merge(parent::behaviors(),[
				VipLogFilter::className(),
				/* 'authBehavior' => [
				 'class' => VipAuthBehavior::className(),
				], */
		]);
	}
	
	
}