<?php

namespace app\modules\vip\controllers\api\vip;

use app\common\utils\CommonUtils;
use app\common\utils\UrlUtils;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\search\VipCaseSearch;
use app\models\b2b2c\VipCase;
use app\modules\vip\common\controllers\BaseApiController;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * VipCaseController implements the CRUD actions for VipCase model.
 */
class VipCaseController extends BaseApiController
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
     * Lists all VipCase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipCaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $models = $dataProvider->getModels();
        foreach ($models as $model) {
        	$model->cover_img_url = UrlUtils::formatUrl($model->cover_img_url);
    		$model->cover_thumb_url = UrlUtils::formatUrl($model->cover_thumb_url);
    		$model->cover_img_original = UrlUtils::formatUrl($model->cover_img_original);
        }
        $pagionationObj = new PaginationObj($models, $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single VipCase model.
     * @param string $id
     * @return mixed
     */
    public function actionView() {
		$id = isset ( $_REQUEST ['id'] ) ? $_REQUEST ['id'] : null;
		$model = $this->findModel ( $id );
		
		$data = ArrayHelper::toArray ($model, [ 
				VipCase::className() => array_merge(CommonUtils::getModelFields($model),[
						'case_type_name' => function($value){
							return $value->type->name;
						},
						
				])
		] );
		return CommonUtils::json_success ( [ 
				"model" => $data,
				'vipCasePhotos' => ArrayHelper::toArray ( $model->vipCasePhotos ) 
		]
		 );
	}


    /**
     * Finds the VipCase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VipCase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	
    	$model = VipCase::find()->alias('case')
    	->joinWith('auditUser auditUser')
        ->joinWith('auditStatus auditStatus')
        ->joinWith('type type')
        ->joinWith('caseFlag caseFlag')
        ->joinWith('status0 stat')
        ->joinWith('status0 isHot')
        ->joinWith('vip vip')
    	->where(['case.id' => $id])->one();
    	
    	$model->cover_img_url = UrlUtils::formatUrl($model->cover_img_url);
    	$model->cover_thumb_url = UrlUtils::formatUrl($model->cover_thumb_url);
    	$model->cover_img_original = UrlUtils::formatUrl($model->cover_img_original);
    	
    	if($model->vipCasePhotos){
    		foreach ($model->vipCasePhotos as $vipCasePhoto) {
    			$vipCasePhoto->img_url = UrlUtils::formatUrl($vipCasePhoto->img_url);
    			$vipCasePhoto->thumb_url = UrlUtils::formatUrl($vipCasePhoto->thumb_url);
    			$vipCasePhoto->img_original = UrlUtils::formatUrl($vipCasePhoto->img_original);
    		}
    	}
    	return $model;
    }
    
    
}
