<?php
namespace app\modules\vip\common\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\b2b2c\common\JsonObj;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\HttpException;
use app\modules\vip\common\filters\VipLogFilter;
use yii\helpers\Json;

class BaseApiController extends BaseController
{
	public $layout= false;
	
}