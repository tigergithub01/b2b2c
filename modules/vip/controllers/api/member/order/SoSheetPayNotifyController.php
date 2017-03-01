<?php

namespace app\modules\vip\controllers\api\member\order;

use app\common\utils\CommonUtils;
use app\common\utils\WxPayUtils;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\Vip;
use app\modules\vip\common\controllers\BaseApiController;
use app\modules\vip\service\order\SoSheetService;

/**
 * SoSheetController implements the CRUD actions for SoSheet model.
 */
class SoSheetPayNotifyController extends BaseApiController {
	
	/**
	 * 微信支付回调函数
	 */
	public function actionWxNotify(){
		//获取通知的数据
		$wxPayUtils = new WxPayUtils();	
		$jsonObj = $wxPayUtils->notify();
		if($jsonObj->status==false){
			return CommonUtils::json_failed($jsonObj->message);
		}
		
		//根据订单编号查询
		$values = $jsonObj->value;		
		$out_trade_no = $values['out_trade_no']; //商户订单号
		$total_fee = ($values['total_fee'] / 100);  //支付总金额（换算成元）
		$pay_type_id = 1; //支付方式->微信支付
		
		$soSheetService = new SoSheetService();
		$payRtn = $soSheetService->soSheetPay($total_fee, $pay_type_id,null, $out_trade_no);
		if($payRtn->status){
			//支付成功
			echo $wxPayUtils->getXMLFromArray($values); //输出信息，告诉支付信息已经修改成功，不需要再定期回掉
			exit;
		}else{
			return CommonUtils::json_encode($payRtn);
			//支付失败
			
		}
		
		
	}
}
