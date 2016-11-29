<?php

namespace app\modules\vip\controllers\api\vip;

use app\common\utils\CommonUtils;
use app\models\b2b2c\common\PaginationObj;
use app\models\b2b2c\search\VipTypeSearch;
use app\models\b2b2c\VipType;
use app\modules\vip\common\controllers\BaseApiController;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * VipTypeController implements the CRUD actions for VipType model.
 */
class VipTypeController extends BaseApiController
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
     * Lists all VipType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VipTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
        $pagionationObj = new PaginationObj($models, $dataProvider->getTotalCount());
        return CommonUtils::json_success($pagionationObj);
    }

    /**
     * Displays a single VipType model.
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
     * Finds the VipType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VipType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = VipType::find()->alias('vt')
    	->joinWith('merchantFlag merc')
    	->where(['vt.id' => $id])->one();
    	if($model !==null){
//         if (($model = VipType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
