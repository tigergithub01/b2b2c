<?php
namespace app\modules\vip\common\controllers;



class BaseApiController extends WebController
{
	//api不需要布局
	public $layout= false;
	
	//不启用csrf
	public $enableCsrfValidation = false;
	
}