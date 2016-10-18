<?php

namespace app\modules\admin\controllers\vip;

use Yii;
use app\models\b2b2c\Vip;
use app\models\b2b2c\search\MerchantSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\utils\MsgUtils;
use app\models\b2b2c\SysParameterType;
use app\models\b2b2c\VipRank;
use app\models\b2b2c\VipType;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\SysUser;
use app\models\b2b2c\VipOrganization;
use app\models\b2b2c\VipExtend;
use app\models\b2b2c\SysRegion;

/**
 * VipController implements the CRUD actions for Vip model.
 */
class MerchantController extends BaseAuthController
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
     * Lists all Vip models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MerchantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'vipRankList' => $this->findVipRankList(),
            	'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            	'vipTypeList' => $this->findVipTypeList(),
            	'sexList' => SysParameterType::getSysParametersById(SysParameterType::VIP_SEX),
        ]);
    }

    /**
     * Displays a single Vip model.
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
     * Creates a new Vip model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vip();
        
        $vipOrganization= new VipOrganization();
        $vipExtend= new VipExtend();

        if ($model->load(Yii::$app->request->post())/*  && $model->save() */) {
        	//加密
        	$model->password = md5($model->password);
        	if($model->save()){
        		MsgUtils::success();
        		return $this->redirect(['view', 'id' => $model->id]);
        	}
           
        }
        
       return $this->render('create', [
                'model' => $model,
       			'vipOrganization' => $vipOrganization,
       			'vipExtend' => $vipExtend,
            	'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            	'vipRankList' => $this->findVipRankList(),
            	'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            	'vipTypeList' => $this->findVipTypeList(),
            	'sexList' => SysParameterType::getSysParametersById(SysParameterType::VIP_SEX),
            	'userList' => $this->findSysUserList(),	
            ]);
    }

    /**
     * Updates an existing Vip model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $vipOrganization = $this->findVipOrganization($model->id);
        if(empty($vipOrganization)){
        	$vipOrganization= new VipOrganization();
        	$vipOrganization->vip_id = $model->id;
        }
        $vipExtend = $this->findVipExtend($model->id);
        if(empty($vipExtend)){
        	$vipExtend= new VipExtend();
        	$vipExtend->vip_id = $model->id;
        }

        if ($model->load(Yii::$app->request->post())  && $vipOrganization->load(Yii::$app->request->post()) && $vipExtend->load(Yii::$app->request->post())) {
        	if($model->save() && $vipOrganization->save() && $vipExtend->save()){
	        	MsgUtils::success();
	            return $this->redirect(['view', 'id' => $model->id]);
        	}
        }/*  else { */
            return $this->render('update', [
                	'model' => $model,
            		'vipOrganization' => $vipOrganization,
            		'vipExtend' => $vipExtend,
            		'yesNoList' => SysParameterType::getSysParametersById(SysParameterType::YES_NO),
            		'vipRankList' => $this->findVipRankList(),
            		'auditStatusList' => SysParameterType::getSysParametersById(SysParameterType::AUDIT_STATUS),
            		'vipTypeList' => $this->findVipTypeList(),
            		'sexList' => SysParameterType::getSysParametersById(SysParameterType::VIP_SEX),
            		'userList' => $this->findSysUserList(),
            		'proviceList' => $this->findSysRegionList(SysRegion::region_type_province),
            		'cityList' => $this->findSysRegionList(SysRegion::region_type_city),
            		'districtList' => $this->findSysRegionList(SysRegion::region_type_district),
            		'countryList' => $this->findSysRegionList(SysRegion::region_type_country),
            ]);
        /* } */
    }

    /**
     * Deletes an existing Vip model.
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
     * Finds the Vip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Vip the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = Vip::find()->alias('vip')
    	->joinWith('status0 stat')
    	->joinWith('auditStatus auditStat')
    	->joinWith('auditUser auditStatUsr')
    	->joinWith('emailVerifyFlag emailVerify')
    	->joinWith('parent parent')
    	->joinWith('merchantFlag mercFlag')
    	->joinWith('vipType vType')
    	->joinWith('mobileVerifyFlag mobileVerify')
    	->joinWith('rank rank')
    	->joinWith('sex0 sex')
    	->where(['vip.id'=>$id])->one();
    	if($model){
//     	if (($model = Vip::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * findVipOrganization
     * @param unknown $id
     * @return unknown
     */
    protected function findVipOrganization($vip_id)
    {
    	$model = VipOrganization::find()->alias('vipOrg')
    	->joinWith('auditUser auditUser')
    	->joinWith('auditStatus auditStatus')
    	->joinWith('district district')
    	->joinWith('city city')
    	->joinWith('country country')
    	->joinWith('province province')
    	->joinWith('vip vip')
    	->joinWith('status0 stat')
    	->where(['vipOrg.vip_id'=>$vip_id])->one();
    	return $model;
    }
    
    /**
     * findVipExtend
     * @param unknown $id
     * @return unknown
     */
    protected function findVipExtend($vip_id)
    {
    	$model = VipExtend::find()->alias('vipExtend')
    	->joinWith('auditUser auditUser')
    	->joinWith('auditStatus auditStatus')
    	->joinWith('vip vip')
    	->where(['vipExtend.vip_id'=>$vip_id])->one();
    	return $model;
    }
    
    /**
     * 
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected  function findVipRankList(){
    	return VipRank::find()->all();
    }
    
   /**
    * 
    */
    protected  function findVipTypeList(){
    	return VipType::find()->where(['merchant_flag'=>SysParameter::yes])->all();
    }
    
    /**
     * 
     * @return Ambigous <multitype:, multitype:\yii\db\ActiveRecord >
     */
    protected function findSysUserList(){
    	return SysUser::find()->all();
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
    
    
}
