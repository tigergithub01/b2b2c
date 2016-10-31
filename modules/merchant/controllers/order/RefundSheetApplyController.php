<?php

namespace app\modules\merchant\controllers\order;

use Yii;
use app\models\b2b2c\RefundSheetApply;
use app\models\b2b2c\search\RefundSheetApplySearch;
use app\modules\merchant\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\SheetType;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\Vip;
use app\modules\merchant\models\MerchantConst;

/**
 * RefundSheetApplyController implements the CRUD actions for RefundSheetApply model.
 */
class RefundSheetApplyController extends BaseAuthController
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
     * Lists all RefundSheetApply models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefundSheetApplySearch();
        
        $searchModel->merchant_id = \Yii::$app->session->get(MerchantConst::LOGIN_MERCHANT_USER)->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'vipList' => $this->findVipList(SysParameter::no),
        		'refundApplyStatusList' => SysParameterType::getSysParametersById(SysParameterType::REFUND_APPLY_STATUS),
        		'soSheetList' => $this->findSoSheetList(),
        ]);
    }

    /**
     * Displays a single RefundSheetApply model.
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
     * Creates a new RefundSheetApply model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RefundSheetApply();
        $model->sheet_type_id = SheetType::ra;
        $model->apply_date = date(MerchantConst::DATE_FORMAT, time());
        $model->sheet_type_id = SheetType::ra;
        $model->code = SheetType::getCode($model->sheet_type_id);
        $model->status = RefundSheetApply::status_need_confirm;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MsgUtils::success();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            		'vipList' => $this->findVipList(SysParameter::no),
            		'refundApplyStatusList' => SysParameterType::getSysParametersById(SysParameterType::REFUND_APPLY_STATUS),
            		'soSheetList' => $this->findSoSheetList(),
            ]);
        }
    }

    /**
     * Updates an existing RefundSheetApply model.
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
            		'refundApplyStatusList' => SysParameterType::getSysParametersById(SysParameterType::REFUND_APPLY_STATUS),
            		'soSheetList' => $this->findSoSheetList(),
            ]);
        }
    }

    /**
     * Deletes an existing RefundSheetApply model.
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
     * Finds the RefundSheetApply model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RefundSheetApply the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	
    	$model = RefundSheetApply::find()->alias("refundApply")
    	->joinWith("vip vip")
    	->joinWith("order order")
    	->joinWith("status0 stat")
    	->where(['refundApply.id' => $id])->one();
    	 
    	if($model){
//         if (($model = RefundSheetApply::findOne($id)) !== null) {
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
    protected  function findSoSheetList(){
    	return SoSheet::find()->all();
    }
    
}