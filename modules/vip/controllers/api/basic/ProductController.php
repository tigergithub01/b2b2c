<?php

namespace app\modules\vip\controllers\api\basic;

use app\common\utils\CommonUtils;
use app\models\b2b2c\Product;
use app\models\b2b2c\search\ProductSearch;
use app\models\b2b2c\Vip;
use app\modules\vip\common\controllers\BaseApiController;
use app\modules\vip\service\basic\ProductService;
use Yii;
use yii\web\NotFoundHttpException;
use app\models\b2b2c\common\PaginationObj;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BaseApiController
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$searchModel = new ProductSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$models = $dataProvider->getModels();
    	
    	
    	//格式化输出
    	$productService = new ProductService();
    	$pagionationObj = new PaginationObj($productService->getProductModelArray($models), $dataProvider->getTotalCount());
    	return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single Product model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);
    	
    	//格式化输出
    	$productService = new ProductService();
    	return CommonUtils::json_success($productService->getProductModelArray($model));
    }

   

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = Product::find()->alias('p')
    	->joinWith('type tp')
    	->joinWith('brand bd')
    	->joinWith('vip vip')
    	->joinWith('isOnSale onSale')
    	->joinWith('isHot hot')
    	->joinWith('auditStatus audit')
    	->joinWith('canReturnFlag rt')
    	->joinWith('isFreeShipping free')
    	->where(['p.id' => $id])->one();
    	if($model !==null){
//     	if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    
   
    
    
}
