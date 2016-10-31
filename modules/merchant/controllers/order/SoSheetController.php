<?php

namespace app\modules\merchant\controllers\order;

use Yii;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\search\SoSheetSearch;
use app\modules\merchant\common\controllers\BaseAuthController;
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
use app\modules\merchant\models\MerchantConst;

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
        $searchModel->merchant_id = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
        
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
        $model = new SoSheet();
        $model->sheet_type_id = SheetType::so;
        $model->code = SheetType::getCode($model->sheet_type_id); 
        $model->order_date = date(MerchantConst::DATE_FORMAT, time());
        $model->integral = 0;
        $model->integral_money = 0;
        $model->coupon = 0;
        $model->discount = 0;
        $model->order_status = SoSheet::order_need_pay;
        $model->pay_status= SoSheet::pay_need_pay;
        $model->deliver_fee = 0;
        $model->order_quantity = 0;
       

        if ($model->load(Yii::$app->request->post()) /* && $model->save() */) {
        	
        	$transaction = SoSheet::getDb()->beginTransaction();
        	try {
        		//重新获取订单编号
        		$model->code = SheetType::getCode($model->sheet_type_id, true);
        		 
        		/* 保存失败处理 */
        		if(!($model->save())){
        			$transaction->rollBack();
        			return $this->renderCreate($model);
        		}
        	
        		$transaction->commit();
        		MsgUtils::success();
        		return $this->redirect(['view', 'id' => $model->id]);
        	
        	}catch (\Exception $e) {
        		$transaction->rollBack();
        		$model->addError('code',$e->getMessage());
        		return $this->renderCreate($model);
        	}
        	
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        }/*  else { */
            return $this->renderCreate($model);
        /* } */
    }
    
    /**
     * @return Ambigous <string, string>
     */
    protected function renderCreate($model){
    	return $this->render('create', [
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
    		throw new NotFoundHttpException('The requested page does not exist.');
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
    		throw new NotFoundHttpException('The requested page does not exist.');
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
            throw new NotFoundHttpException('The requested page does not exist.');
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
    
}