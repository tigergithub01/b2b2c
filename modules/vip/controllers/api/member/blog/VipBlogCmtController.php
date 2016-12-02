<?php

namespace app\modules\vip\controllers\api\member\blog;

use app\common\utils\CommonUtils;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\VipBlogCmt;
use app\modules\vip\common\controllers\BaseAuthApiController;
use app\modules\vip\models\VipConst;
use Yii;

/**
 * VipBlogCmtController implements the CRUD actions for VipBlogCmt model.
 */
class VipBlogCmtController extends BaseAuthApiController
{
    
	/**
	 * Creates a new VipBlogCmt model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new VipBlogCmt();
		$model->reply_date = date(VipConst::DATE_FORMAT, time());
		$model->vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
		$model->status = SysParameter::no;
	
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return CommonUtils::json_success($model->id);
		} else {
			return CommonUtils::jsonModel_failed($model);
		}
	}
    
    
}
