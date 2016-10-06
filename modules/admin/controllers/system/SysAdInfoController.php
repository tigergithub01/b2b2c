<?php

namespace app\modules\admin\controllers\system;

use Yii;
use app\models\b2b2c\SysAdInfo;
use app\models\b2b2c\search\SysAdInfoSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SysAdInfoController implements the CRUD actions for SysAdInfo model.
 */
class SysAdInfoController extends BaseAuthController
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
     * Lists all SysAdInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysAdInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SysAdInfo model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	/* $imageUtils = new \app\common\utils\ImageUtils();
//     	var_dump(getimagesize(iconv("UTF-8", "GBK",  "uploads/ads/1610/ads_详细2_161006121640_4942.png")));
    	if($thumbed_url = ($imageUtils->make_thumb("uploads/ads/1610/3.png",200,200))){
//     		unlink(iconv("UTF-8", "GBK",  $thumb_url));
    	}
    	
//     	$image = new \app\common\utils\ImageThumb(iconv("UTF-8", "GBK",  "uploads/ads/1610/ads_详细2_161006121640_4942.png"));
//     	$image->openImage();
//     	$image->thumpImage(400,400);
//     	$image->showImage();
//     	$image->saveImage(md5("aa123"));
    	
    	return; */
    	return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SysAdInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SysAdInfo();
        if ($model->load(Yii::$app->request->post())) {
        	$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        	if($files = ($model->upload())){
        		$model->img_url = $files['img_url'];
        		$model->img_original = $files['img_original'];
        		$model->thumb_url = $files['thumb_url'];
        	}
        	if($model->save()){
	            return $this->redirect(['view', 'id' => $model->id]);
        	}else{
        		var_dump($model->errors);
        		return $this->render('create', [
        				'model' => $model,
        		]);
        	}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SysAdInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SysAdInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->delete()){
        	$thumb_url = iconv("UTF-8", "GBK", Yii::getAlias('@webroot') . $model->thumb_url);
        	$img_original = iconv("UTF-8", "GBK", Yii::getAlias('@webroot') . $model->img_original);
        	$img_url = iconv("UTF-8", "GBK", Yii::getAlias('@webroot') . $model->img_url);
        	
        	if(is_file($thumb_url)){
        		unlink($thumb_url);
        	}
        	if(file_exists($img_original)){
        		unlink($img_original);
        	}
        	if(file_exists($img_url)){
        		unlink($img_url);
        	}
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the SysAdInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SysAdInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SysAdInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
}
