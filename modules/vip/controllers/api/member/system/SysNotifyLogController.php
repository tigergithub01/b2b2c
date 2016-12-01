<?php

namespace app\modules\vip\controllers\api\member\system;

use Yii;
use app\modules\vip\common\controllers\BaseAuthApiController;
use app\models\b2b2c\common\JsonObj;
use yii\helpers\Json;
use app\common\utils\UrlUtils;
use app\common\utils\CommonUtils;
use app\models\b2b2c\common\PaginationObj;
use yii\helpers\ArrayHelper;
use app\models\b2b2c\SysNotifyLog;
use app\models\b2b2c\search\SysNotifyLogSearch;
use app\modules\vip\models\VipConst;
use app\models\b2b2c\VipConcern;

/**
 * SysNotifyLogController implements the CRUD actions for SysNotifyLog model.
 */
class SysNotifyLogController extends BaseAuthApiController
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
     * Lists all SysNotifyLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysNotifyLogSearch();
        $searchModel->vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
        
        //格式化输出
        $data = ArrayHelper::toArray ($models, [
        		SysNotifyLog::className() => array_merge(CommonUtils::getModelFields(new SysNotifyLog()),[
        			'title' => function($value){
        				//通知标题
        				return (empty($value->notify)?'':$value->notify->title);
        			},
        			'issue_date' => function($value){
        				//通知创建日期
        				return (empty($value->notify)?'':$value->notify->issue_date);
        			},
        			'notify_type_name' => function($value){
	        			//通知类型
	        			return ((empty($value->notify) || empty($value->notify->notifyType)) ?'':$value->notify->notifyType->param_val);
        			},
        		])
        	]);
        
        $pagionationObj = new PaginationObj($data, $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single SysNotifyLog model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
    	$model = $this->findModel($id);
    	
    	$vip_id = \Yii::$app->session->get(VipConst::LOGIN_VIP_USER)->id;
    	if($model->vip_id != $vip_id){
    		return CommonUtils::json_failed("非法读取消息，只能读取自己的消息！");
    	}
    	
    	if(empty($model->read_date)){
    		//第一次查看消息时，写入阅读时间
    		$model->read_date = date(VipConst::DATE_FORMAT , time());
    		$model->update(true,['read_date']);
    	}
    	
    	
    	//格式化输出
    	$data = ArrayHelper::toArray ($model, [
    			SysNotifyLog::className() => array_merge(CommonUtils::getModelFields($model),[
    				'title' => function($value){
    					//通知标题
    					return (empty($value->notify)?'':$value->notify->title);
    				},
    				'content' => function($value){
    					//通知标题
    					return (empty($value->notify)?'':$value->notify->content);
    				},
    				'issue_date' => function($value){
    					//通知创建日期
    					return (empty($value->notify)?'':$value->notify->issue_date);
    				},
    				'notify_type_name' => function($value){
    					//通知类型
    					return ((empty($value->notify) || empty($value->notify->notifyType)) ?'':$value->notify->notifyType->param_val);
    				},
    			])
    		]);
    	
    	
    	
    	
    	return CommonUtils::json_success($data);
    }


    /**
     * Finds the SysNotifyLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SysNotifyLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = SysNotifyLog::find()->alias('notifyLog')
    	->joinWith('vip vip')
    	->joinWith('notify notify')
    	->where(['notifyLog.id'=>$id])->one();
    	
    	return $model;
    }
}
