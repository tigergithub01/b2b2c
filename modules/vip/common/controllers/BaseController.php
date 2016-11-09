<?php
namespace app\modules\vip\common\controllers;

use app\modules\vip\common\filters\VipLogFilter;

class BaseController extends WebController
{
	public $layout="main-blank";
	
	public function behaviors()
	{
		return [
				/* 'access' => [
						'class' => AccessControl::className(),
// 						'only' => ['logout'],
						'rules' => [
								[
										'actions' => ['logout'],
										'allow' => true,
								],
						],
				], */
				'logFilter' => [
					'class' => VipLogFilter::className(),
// 						'class' => "app\modules\admin\common\filters\AdminAuthFilter",
				],
		];
	}
	
	
	
}