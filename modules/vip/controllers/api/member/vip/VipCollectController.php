<?php

namespace app\modules\vip\controllers\api\member\vip;

use app\common\utils\CommonUtils;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\search\VipCollectSearch;
use app\models\b2b2c\VipCollect;
use app\modules\vip\common\controllers\BaseAuthApiController;
use app\modules\vip\models\VipConst;
use Yii;

/**
 * VipCollectController implements the CRUD actions for VipCollect model.
 */
class VipCollectController extends BaseAuthApiController
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
     * Lists all VipCollect models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipCollectSearch();
        $searchModel->vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
        $pagionationObj = new PaginationObj($models, $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single VipCollect model.
     * @param string $id
     * @return mixed
     */
    public function actionView()
    {
       	$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
    	$model = $this->findModel($id);
    	
    	return CommonUtils::json_success($model);
    }
    
    /**
     * Creates a new VipCollect model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new VipCollect();
    	$vip_user = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER);    	
    	$model->vip_id = $vip_user->id;
    	$model->collect_date = date(VipConst::DATE_FORMAT, time());
    	
    	if ($model->load(Yii::$app->request->post()) && $model->validate() /* && $model->save() */) {
    		
    		if($model->collect_type==VipCollect::collect_case){
    			//案例不能为空
    			if(empty($model->case_id)){
    				$model->addError("案例不能为空！");
    				return CommonUtils::jsonModel_failed($model);
    			}
    			
    			//已经收藏的案例不能重复收藏
    			$count = VipCollect::find()->where(['vip_id'=>$vip_user->id, 'case_id'=>$model->case_id])->count();
    			if($count>=1){
    				return CommonUtils::json_failed("您已经收藏该案例!");
    			}    			
    		}else if ($model->collect_type==VipCollect::collect_vip){
    			
    		}else if ($model->collect_type==VipCollect::collect_prod){
    			
    		}else if ($model->collect_type==VipCollect::collect_act){
    			
    		}else if ($model->collect_type==VipCollect::collect_blog){
    			
    		}
    		
    		if($model->save()){
    			return CommonUtils::json_success($model->id);
    		}
    		
    	} /* else { */
    		return CommonUtils::jsonMsgObj_failed('收藏失败！', $model);
    	/* } */
    }
    
    
    /**
     * Deletes an existing VipCollect model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	//TODO：只能取消自己的收藏
    	$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
    	$model = $this->findModel($id);   	
    	
    	
    	$this->findModel($id)->delete();
    	MsgUtils::success();
    	return $this->redirect(['index']);
    }


    /**
     * Finds the VipCollect model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VipCollect the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = VipCollect::find()->alias('vipCollect')
    	->joinWith('vip vip')
    	->joinWith('package package')
    	->joinWith('case case')
    	->joinWith('product product')
    	->where(['vipCollect.id' => $id])->one();
    	
    	return $model;
    }
}
