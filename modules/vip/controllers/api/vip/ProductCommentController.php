<?php

namespace app\modules\vip\controllers\api\vip;

use app\common\utils\CommonUtils;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\ProductComment;
use app\models\b2b2c\search\ProductCommentSearch;
use app\models\b2b2c\SysParameter;
use app\models\b2b2c\Vip;
use app\modules\vip\common\controllers\BaseApiController;
use Yii;
use yii\helpers\ArrayHelper;
use app\common\utils\UrlUtils;

/**
 * ProductCommentController implements the CRUD actions for ProductComment model.
 */
class ProductCommentController extends BaseApiController
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
     * Lists all ProductComment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductCommentSearch();
        $searchModel->status = SysParameter::yes;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
        
        //格式化输出
        $data = ArrayHelper::toArray ($models, [
        		ProductComment::className() => array_merge(CommonUtils::getModelFields(new ProductComment()),[
        				'vip_name' => function($value){
	        				return (empty($value->vip)?'':$value->vip->vip_name);
	        			},
	        			'thumb_url' => function($value){
	        				return (empty($value->vip)?'':$value->vip->thumb_url);
	        			},
	        			'cmt_rank_name'=> function($value){
	        				return (empty($value->cmtRank)?'':$value->cmtRank->param_val);
	        			},	
	        			'productCommentPhotos'=> function($value){
	        				if($value->productCommentPhotos){
	        					foreach ($value->productCommentPhotos as $productCommentPhoto) {
	        						$productCommentPhoto['img_url'] = UrlUtils::formatUrl($productCommentPhoto['img_url']);
	        						$productCommentPhoto['thumb_url'] = UrlUtils::formatUrl($productCommentPhoto['thumb_url']);
	        						$productCommentPhoto['img_original'] = UrlUtils::formatUrl($productCommentPhoto['img_original']);
	        					}
	        				}
	        				return $value->productCommentPhotos;
	        			},
        		])
        	]);
        
        $pagionationObj = new PaginationObj($data, $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single ProductComment model.
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
     * Finds the ProductComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        
    	$model = ProductComment::find()->alias('pcmt')
    	->joinWith('status0 stat')
    	->joinWith('cmtRank cmtRank')
    	->joinWith('parent parent')
    	->joinWith('vip vip')
    	->joinWith('product prod')
    	->where(['pcmt.id'=>$id])->one();
    	
    	return $model;
    }
    
    
}
