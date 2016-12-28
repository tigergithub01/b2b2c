<?php

namespace app\modules\vip\controllers\api\basic;

use app\common\utils\CommonUtils;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\ProductType;
use app\models\b2b2c\search\ProductTypeSearch;
use app\modules\vip\service\basic\ProductTypeService;
use Yii;
use yii\web\NotFoundHttpException;
use app\modules\vip\common\controllers\BaseApiController;


/**
 * ProductTypeController implements the CRUD actions for ProductType model.
 */
class ProductTypeController extends BaseApiController
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
     * Lists all ProductType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $models = $dataProvider->getModels();
        
        //格式化输出
        $productTypeService = new ProductTypeService();
        $pagionationObj = new PaginationObj($productTypeService->getProductTypeModelArray($models), $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single ProductType model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);
    	 
    	//格式化输出
    	$productTypeService = new ProductTypeService();
    	return CommonUtils::json_success($productTypeService->getProductTypeModelArray($model));
    	
    }

    

    /**
     * Finds the ProductType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	if (($model = ProductType::find()->alias('p')->joinWith("parent pp")->where(['p.id'=>$id])->one()) !== null) {
//         if (($model = ProductType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    
}
