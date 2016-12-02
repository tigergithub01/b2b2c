<?php

namespace app\modules\vip\controllers\member\order;

use Yii;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\search\SoSheetSearch;
use app\modules\vip\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysRegion;
use app\models\b2b2c\PayType;
use app\models\b2b2c\PickUpPoint;
use app\models\b2b2c\SheetType;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\DeliveryTypeTpl;
use app\models\b2b2c\SoSheetDetail;
use app\models\b2b2c\Activity;
use app\models\b2b2c\Product;
use app\modules\vip\models\VipConst;
use app\models\b2b2c\SoSheetVip;
use yii\db\Query;

/**
 * SoSheetController implements the CRUD actions for SoSheet model.
 */
class SoSheetController extends BaseAuthController
{
    /**
     * @inheritdoc
     */
     /*
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    */

    /**
     * Lists all SoSheet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SoSheetSearch();
        $searchModel->vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'vipList' => $this->findVipList(SysParameter::no),
        		'proviceList' => $this->findSysRegionList(SysRegion::region_type_province),
        		'cityList' => $this->findSysRegionList(SysRegion::region_type_city),
        		'districtList' => $this->findSysRegionList(SysRegion::region_type_district),
        		'countryList' => $this->findSysRegionList(SysRegion::region_type_country),
        		'deliveryStatusList' => SysParameterType::getSysParametersById(SysParameterType::SHIPPING_STATUS),
        		'invoiceTypeList' => SysParameterType::getSysParametersById(SysParameterType::INVOICE_TYPE),
        		'orderStatusList' => SysParameterType::getSysParametersById(SysParameterType::ORDER_STATUS),
        		'payStatusList' => SysParameterType::getSysParametersById(SysParameterType::PAY_STATUS),
        		'payTypeList' => $this->findPayTypeList(),
        		'deliveryTypeList' => $this->findDeliveryTypeList(),
        		'pickUpPointList' => $this->findPickUpPointList(),
        		'sheetTypeList' => $this->findSheetTypeList(),
        		'serviceStyleList' => SysParameterType::getSysParametersById(SysParameterType::SERVICE_STYLE),
        		'relatedServiceList' => SysParameterType::getSysParametersById(SysParameterType::RELATED_SERVICE),
        ]);
    }

    /**
     * Displays a single SoSheet model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model =  $this->findModel($id);
    	$soSheetDetailList = $this->findSoSheetDetailList($id);
    	 
    	return $this->render('view', [
    			'model' => $model,
    			'soSheetDetailList' => $soSheetDetailList,
    	]);
    }

    
    
    
    /**
     * Creates a new SoSheet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    
    	//get request parameter sheet_type_id
    	//         $model->load(Yii::$app->request->get());
    	//get parameters
    	$product_id = isset($_REQUEST['product_id'])?$_REQUEST['product_id']:null; //购买个人服务编号
    	if(empty($product_id)){
    		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
    	
    	$model = new SoSheet();
    	$model->sheet_type_id = SheetType::so;
    	$model->code = SheetType::getCode($model->sheet_type_id);
    	$model->order_date = date(VipConst::DATE_FORMAT, time());
    	$model->integral = 0;
    	$model->integral_money = 0;
    	$model->coupon = 0;
    	$model->discount = 0;
    	$model->order_status = SoSheet::order_need_pay;
    	$model->pay_status= SoSheet::pay_need_pay;
    	$model->deliver_fee = 0;
    	$model->order_quantity = 1;
    	$model->goods_amt = 0;
    	$model->order_amt = 0;
    
    	$vip_user = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER);
    	$model->vip_id = $vip_user->id;
    	$model->consignee = $vip_user->vip_name;
    	$model->mobile = $vip_user->vip_id;
    	
    	//根据产品编号计算出订单总金额
    	$product = Product::findOne($product_id);
    	$model->goods_amt = $product->sale_price;
    	$model->order_amt = $product->sale_price;
    
    	if ($model->load(Yii::$app->request->post()) /* && $model->save() */) {
    		 
    		$transaction = SoSheet::getDb()->beginTransaction();
    		try {
    			//重新获取订单编号
    			$model->code = SheetType::getCode($model->sheet_type_id, true);
    			$model->order_date = date(VipConst::DATE_FORMAT, time());
    			
    			 
    			/* 保存失败处理 */
    			if(!($model->save())){
    				$transaction->rollBack();
    				return $this->renderCreate($model);
    			}
    
    
    			/* 写订单明细 */
	    		$soSheetDetail = new SoSheetDetail();
	    		$soSheetDetail->order_id = $model->id;
	    		$soSheetDetail->product_id = $product_id;
	    		$soSheetDetail->quantity = 1;
	    		$soSheetDetail->price = $product->sale_price;
	    		$soSheetDetail->amount = $soSheetDetail->quantity * $soSheetDetail->price;
	    		if(!$soSheetDetail->save()){
	    			$transaction->rollBack();
	    			return $this->renderCreate($model);
	    		}
	    		
	    		/* 订单商户对应关系 */
	    		$vip_ids = $this->findVipIdList($model->id);
	    		 
	    		//delete frist
	    		SoSheetVip::deleteAll(['order_id'=>$model->id]);
	    		//insert last
	    		foreach ($vip_ids as $vip_id) {
	    			$soSheetVip = new SoSheetVip();
	    			$soSheetVip->vip_id = $vip_id;
	    			$soSheetVip->order_id = $model->id;
	    			if(!$soSheetVip->save()){
	    				MsgUtils::error();
	    				$transaction->rollBack();
	    				return $this->renderCreate($model);
	    			}
	    		}
    				
    			$transaction->commit();
    			MsgUtils::success();
    			return $this->redirect(['view', 'id' => $model->id]);
    			 
    		}catch (\Exception $e) {
    			$transaction->rollBack();
    			//         		$model->addError('code',$e->getMessage());
    			MsgUtils::error("订单提交出错："  . $e->getMessage());
    			return $this->renderCreate($model);
    		}
    		 
    		MsgUtils::success();
    		return $this->redirect(['view', 'id' => $model->id]);
    	}/*  else { */
    	return $this->renderCreate($model);
    	/* } */
    }
    
    
    /**
     * Creates a new SoSheet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatePackage()
    {
    
    	//get request parameter sheet_type_id
    	//         $model->load(Yii::$app->request->get());
    	//get parameters
    	$activity_id = isset($_REQUEST['activity_id'])?$_REQUEST['activity_id']:null; //购买团体服务
    	if(empty($activity_id)){
    		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
    
    	$model = new SoSheet();
    	$model->sheet_type_id = SheetType::so;
    	$model->code = SheetType::getCode($model->sheet_type_id);
    	$model->order_date = date(VipConst::DATE_FORMAT, time());
    	$model->integral = 0;
    	$model->integral_money = 0;
    	$model->coupon = 0;
    	$model->discount = 0;
    	$model->order_status = SoSheet::order_need_pay;
    	$model->pay_status= SoSheet::pay_need_pay;
    	$model->deliver_fee = 0;
    	$model->order_quantity = 1;
    	$model->goods_amt = 0;
    	$model->order_amt = 0;
    
    	$vip_user = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER);
    	$model->vip_id = $vip_user->id;
    	$model->consignee = $vip_user->vip_name;
    	$model->mobile = $vip_user->vip_id;
    
    	//根据团体服务编号计算出订单总金额
    	$activity = Activity::findOne($activity_id);
    	$model->goods_amt = $activity->package_price;
    	$model->order_amt = $activity->package_price;
    
    	if ($model->load(Yii::$app->request->post()) /* && $model->save() */) {
    		 
    		$transaction = SoSheet::getDb()->beginTransaction();
    		try {
    			//重新获取订单编号
    			$model->code = SheetType::getCode($model->sheet_type_id, true);
    			$model->order_date = date(VipConst::DATE_FORMAT, time());
    
    			 
    			/* 保存失败处理 */
    			if(!($model->save())){
    				$transaction->rollBack();
    				return $this->renderCreate($model, 'create-package');
    			}
    
    			/* 写订单明细 */
    			$soSheetDetail = new SoSheetDetail();
    			$soSheetDetail->order_id = $model->id;
    			$soSheetDetail->package_id = $activity_id;
    			$soSheetDetail->quantity = 1;
    			$soSheetDetail->price = $activity->package_price;
    			$soSheetDetail->amount = $soSheetDetail->quantity * $soSheetDetail->price;
    			if(!$soSheetDetail->save()){
    				$transaction->rollBack();
    				return $this->renderCreate($model, 'create-package');
    			}
    
    			/* 订单商户对应关系 */
	    		$vip_ids = $this->findVipIdList($model->id);
	    		 
	    		//delete frist
	    		SoSheetVip::deleteAll(['order_id'=>$model->id]);
	    		//insert last
	    		foreach ($vip_ids as $vip_id) {
	    			$soSheetVip = new SoSheetVip();
	    			$soSheetVip->vip_id = $vip_id;
	    			$soSheetVip->order_id = $model->id;
	    			if(!$soSheetVip->save()){
	    				MsgUtils::error();
	    				$transaction->rollBack();
	    				return $this->renderCreate($model, 'create-package');
	    			}
	    		}
    				
    			$transaction->commit();
    			MsgUtils::success();
    			return $this->redirect(['view', 'id' => $model->id]);
    			 
    		}catch (\Exception $e) {
    			$transaction->rollBack();
    			//         		$model->addError('code',$e->getMessage());
    			MsgUtils::error("订单提交出错："  . $e->getMessage());
    			return $this->renderCreate($model, 'create-package');
    		}
    		 
    		MsgUtils::success();
    		return $this->redirect(['view', 'id' => $model->id]);
    	}/*  else { */
    	return $this->renderCreate($model, 'create-package');
    	/* } */
    }
    
    
    
    /**
     * Creates a new SoSheet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateConsult()
    {
    
    	//get request parameter sheet_type_id
    	//         $model->load(Yii::$app->request->get());
    	//get parameters
    	$merchant_id = isset($_REQUEST['merchant_id'])?$_REQUEST['merchant_id']:null; //订单咨询商户编号
    	$merchant = Vip::find()->where(['id' => $merchant_id, 'merchant_flag' => SysParameter::yes])->one();
    	if(empty($merchant)){
    		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
    
    	$model = new SoSheet();
    	$model->sheet_type_id = SheetType::sc;
    	$model->code = SheetType::getCode($model->sheet_type_id);
    	$model->order_date = date(VipConst::DATE_FORMAT, time());
    	$model->integral = 0;
    	$model->integral_money = 0;
    	$model->coupon = 0;
    	$model->discount = 0;
    	$model->order_status = SoSheet::order_need_pay;
    	$model->pay_status= SoSheet::pay_need_pay;
    	$model->deliver_fee = 0;
    	$model->order_quantity = 1;
    	$model->goods_amt = 0;
    	$model->order_amt = 0;
    	$model->merchant_id = $merchant_id;
    
    	$vip_user = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER);
    	$model->vip_id = $vip_user->id;
    	$model->consignee = $vip_user->vip_name;
    	$model->mobile = $vip_user->vip_id;
    	 
    
    	if ($model->load(Yii::$app->request->post()) /* && $model->save() */) {
    		 
    		$transaction = SoSheet::getDb()->beginTransaction();
    		try {
    			//重新获取订单编号
    			$model->code = SheetType::getCode($model->sheet_type_id, true);
    			$model->order_date = date(VipConst::DATE_FORMAT, time());
    			 
    
    			/* 保存失败处理 */
    			if(!($model->save())){
    				$transaction->rollBack();
    				return $this->renderCreate($model, 'create-consult');
    			}
    
    			/* 订单商户对应关系 */
//     			$vip_ids = $this->findVipIdList($model->id);
    			$soSheetVip = new SoSheetVip();
    			$soSheetVip->vip_id = $merchant_id;
    			$soSheetVip->order_id = $model->id;
    			if(!$soSheetVip->save()){
    				MsgUtils::error();
    				$transaction->rollBack();
    				return $this->renderCreate($model, 'create-consult');
    			}
    
    			$transaction->commit();
    			MsgUtils::success();
    			return $this->redirect(['view', 'id' => $model->id]);
    
    		}catch (\Exception $e) {
    			$transaction->rollBack();
    			//         		$model->addError('code',$e->getMessage());
    			MsgUtils::error("订单提交出错："  . $e->getMessage());
    			return $this->renderCreate($model, 'create-consult');
    		}
    		 
    		MsgUtils::success();
    		return $this->redirect(['view', 'id' => $model->id]);
    	}/*  else { */
    	return $this->renderCreate($model, 'create-consult');
    	/* } */
    }
    
    
    
    /**
     * @return Ambigous <string, string>
     */
    protected function renderCreate($model, $action= 'create'){
    	return $this->render($action, [
                'model' => $model,
            		'vipList' => $this->findVipList(SysParameter::no),
            		'proviceList' => $this->findSysRegionList(SysRegion::region_type_province),
            		'cityList' => $this->findSysRegionList(SysRegion::region_type_city),
            		'districtList' => $this->findSysRegionList(SysRegion::region_type_district),
            		'countryList' => $this->findSysRegionList(SysRegion::region_type_country),
            		'deliveryStatusList' => SysParameterType::getSysParametersById(SysParameterType::SHIPPING_STATUS),
            		'invoiceTypeList' => SysParameterType::getSysParametersById(SysParameterType::INVOICE_TYPE),
            		'orderStatusList' => SysParameterType::getSysParametersById(SysParameterType::ORDER_STATUS),
            		'payStatusList' => SysParameterType::getSysParametersById(SysParameterType::PAY_STATUS),
            		'payTypeList' => $this->findPayTypeList(),
            		'deliveryTypeList' => $this->findDeliveryTypeList(),
            		'pickUpPointList' => $this->findPickUpPointList(),
            		'sheetTypeList' => $this->findSheetTypeList(),
            		'serviceStyleList' => SysParameterType::getSysParametersById(SysParameterType::SERVICE_STYLE),
            		'relatedServiceList' => SysParameterType::getSysParametersById(SysParameterType::RELATED_SERVICE),
            ]);
    }

    /**
     * Updates an existing SoSheet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            		'vipList' => $this->findVipList(SysParameter::no),
            		'proviceList' => $this->findSysRegionList(SysRegion::region_type_province),
            		'cityList' => $this->findSysRegionList(SysRegion::region_type_city),
            		'districtList' => $this->findSysRegionList(SysRegion::region_type_district),
            		'countryList' => $this->findSysRegionList(SysRegion::region_type_country),
            		'deliveryStatusList' => SysParameterType::getSysParametersById(SysParameterType::SHIPPING_STATUS),
            		'invoiceTypeList' => SysParameterType::getSysParametersById(SysParameterType::INVOICE_TYPE),
            		'orderStatusList' => SysParameterType::getSysParametersById(SysParameterType::ORDER_STATUS),
            		'payStatusList' => SysParameterType::getSysParametersById(SysParameterType::PAY_STATUS),
            		'payTypeList' => $this->findPayTypeList(),
            		'deliveryTypeList' => $this->findDeliveryTypeList(),
            		'pickUpPointList' => $this->findPickUpPointList(),
            		'sheetTypeList' => $this->findSheetTypeList(),
            		'serviceStyleList' => SysParameterType::getSysParametersById(SysParameterType::SERVICE_STYLE),
            		'relatedServiceList' => SysParameterType::getSysParametersById(SysParameterType::RELATED_SERVICE),
            ]);
        }
    }

    /**
     * Deletes an existing SoSheet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		MsgUtils::success();
        return $this->redirect(['index']);
    }
    
    
    /**
     * 添加团队成员
     * @return \yii\web\Response|Ambigous <string, string>
     */
    public function actionCreateSoSheetDetail($order_id){
    	$model = new SoSheetDetail();
    	$model->order_id = $order_id;
    	$model->quantity = 1;
    	$model->amount = 0;
    	 
    	//查询订单
    	$soSheet = SoSheet::findOne($order_id);
    	if(empty($soSheet)){
    		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
    	 
    	if ($model->load(Yii::$app->request->post())) {
    		
    		$model->amount = $model->quantity * $model->price;
    		
    		//save
    		if($model->save()){
    			MsgUtils::success();
    			return $this->redirect(['view', 'id' => $order_id]);
    		}
    	}

    	/* else { */
    	return $this->render('create-so-sheet-detail', [
    			'model' => $model,
    			'soSheet' => $soSheet,
    			'activityList' => $this->findActivityList(),
            	'productList' => $this->findProductList(),
            	'soSheetList' => $this->findSoSheetList(),
    	]);
    	/* } */
    }
    
    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDeleteSoSheetDetail($id)
    {
    	$soSheetDetail = SoSheetDetail::findOne($id);
    	if(empty($soSheetDetail)){
    		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
    	$soSheetDetail->delete();
    	MsgUtils::success();
    	return $this->redirect(['view','id'=>$soSheetDetail->order_id]);
    }

    /**
     * Finds the SoSheet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SoSheet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	
    	$model = SoSheet::find()->alias("so")
    	->joinWith("vip vip")
    	->joinWith("city city")
    	->joinWith("country country")
    	->joinWith("deliveryStatus deliveryStatus")
    	->joinWith("district district")
    	->joinWith("invoiceType invoiceType")
    	->joinWith("orderStatus orderStatus")
    	->joinWith("payStatus payStatus")
    	->joinWith("province province")
    	->joinWith("deliveryType deliveryType")
    	->joinWith("payType payType")
    	->joinWith("pickPoint pickPoint")
    	->joinWith("sheetType sheetType")
    	->joinWith("serviceStyle serviceStyle")
    	->where(['so.id' => $id])->one();
    	
    	if($model){
    		if($model->related_services){
    			$related_service_names = [];
    			foreach ($model->related_services as $value) {
    				$related_service_names[] =  SysParameter::findOne($value)->param_val;
    			}
    			$model->related_service_names = implode("，", $related_service_names);
    		}
//     	if (($model = SoSheet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipList($merchant_flag){
    	return Vip::find()->where(['merchant_flag'=>$merchant_flag])->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findSysRegionList($region_type, $parent_id = null){
    	return SysRegion::find()
    	->where(['region_type' =>$region_type])
    	->andFilterWhere(['parent_id' => $parent_id])->limit(100)->offset(0)->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findPayTypeList(){
    	return PayType::find()->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findDeliveryTypeList(){
    	return DeliveryTypeTpl::find()->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findPickUpPointList(){
    	return PickUpPoint::find()->all();
    }
    
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findSheetTypeList(){
    	return SheetType::find()->where(['id' => [SheetType::so, SheetType::sc]])->all();
    }
    
    /**
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findActivityList(){
    	return Activity::find()->all();
    }
    
    /**
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findSoSheetList(){
    	return SoSheet::find()->all();
    }
    
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findProductList(){
    	return Product::find()->all();
    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    function findSoSheetDetailList($order_id){
    	$models = SoSheetDetail::find()->alias('soDetail')
    	->joinWith('order order')
    	->joinWith('package package')
    	->joinWith('product product')
    	->where(['soDetail.order_id' => $order_id])->all();
    	return $models;
    }
    
    /**
     * 查询订单产品所关联的商户编号
     * @param unknown $order_id
     * @return unknown
     */
    private function findVipIdList($order_id){
    	$query = new \yii\db\Query();
    	$query = SoSheetDetail::find()->select("vip.id")->alias("so_detail")->joinWith("product.vip vip")->where(['so_detail.order_id' => $order_id])->andWhere(['IS NOT',"so_detail.product_id",NULL])->distinct();
    	 
    	$query_package = new Query();
    	$query_package = SoSheetDetail::find()->select("vip.id")->alias("so_detail")->joinWith("package.vip vip")->where(['so_detail.order_id' => $order_id])->andWhere(['IS NOT',"so_detail.package_id",NULL])->distinct();
    	$query->union($query_package);
    	$vip_ids = $query->column();
    	return $vip_ids;
    }
    
}
