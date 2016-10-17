<?php

namespace app\modules\admin\controllers\order;

use Yii;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\search\SoSheetSearch;
use app\modules\admin\common\controllers\BaseAuthController;
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
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
    
}
