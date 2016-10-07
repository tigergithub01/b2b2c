<?php

namespace app\modules\admin\controllers\system;

use Yii;
use app\models\b2b2c\SysAdInfo;
use app\models\b2b2c\search\SysAdInfoSearch;
use app\modules\admin\common\controllers\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\common\utils\ImageUtils;
use app\models\b2b2c\common\Constant;
use app\models\b2b2c\SysConfig;

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
        $model->setScenario(SysAdInfo::SCENARIO_CREATE);
        
        //获取默认配置文件
        $model->width = SysConfig::getConfigVal("thumb_width");
        $model->height = SysConfig::getConfigVal("thumb_height");;
        
        if ($model->load(Yii::$app->request->post())) {
        	$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        	$imageUtils = new ImageUtils();
        	if($files = ($imageUtils->uploadImage($model->imageFile, 'uploads/ads', 'ads',null, $model->width,$model->height))){
        		$model->img_url = $files['img_url'];
        		$model->img_original = $files['img_original'];
        		$model->thumb_url = $files['thumb_url'];
        	}
        	if($model->save()){
        		//rename file name
        		$file_info = pathinfo($model->img_original);
//         		rename($model->img_original, $file_info)
        		$new_img_original =  $imageUtils->renameImage($model->img_original, $model->id, 'ads');
        		$new_thumb_url = $imageUtils->renameImage($model->thumb_url, $model->id, 'ads', Constant::thumb_flag);
        		$new_img_url = $imageUtils->renameImage($model->img_url, $model->id, 'ads', Constant::img_flag);
        		if($new_img_original){
        			$model->img_original = $new_img_original;
        		}
        		if($new_thumb_url){
        			$model->thumb_url = $new_thumb_url;
        		}
        		if($new_img_url){
        			$model->img_url = $new_img_url;
        		}        	
        			
        		if($model->update(true,['img_original','thumb_url', 'img_url'])){
        			return $this->redirect(['view', 'id' => $model->id]);
        		}else{
        			return $this->render('create', [
        					'model' => $model,
        			]);
        		}
        	}else{
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
        $model->setScenario(SysAdInfo::SCENARIO_UPDATE);
        if ($model->load(Yii::$app->request->post())) {
        	
        	$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        	if(empty($model->imageFile)){
        		//如果没有上传文件，则不处理文件信息
        		if($model->update()){
        			return $this->redirect(['view', 'id' => $model->id]);
        		}else{
        			return $this->render('update', [
        					'model' => $model,
        			]);
        		}
        	}else{
        		$imageUtils = new ImageUtils();
        		if($files = ($imageUtils->uploadImage($model->imageFile, 'uploads/ads', 'ads', $model->id, $model->width,$model->height))){
        			$old_img_url = $model->img_url;
        			$old_img_original = $model->img_original;
        			$old_thumb_url = $model->thumb_url;
        		
        			$model->img_url = $files['img_url'];
        			$model->img_original = $files['img_original'];
        			$model->thumb_url = $files['thumb_url'];
        		
        			if($model->update()){
        				//remove old files;
        				if(file_exists($old_img_url)){
        					unlink($old_img_url);
        				}
        				if(file_exists($old_img_original)){
        					unlink($old_img_original);
        				}
        				if(file_exists($old_thumb_url)){
        					unlink($old_thumb_url);
        				}
        				return $this->redirect(['view', 'id' => $model->id]);
        			}else{
        				return $this->render('update', [
        						'model' => $model,
        				]);
        			}
        		}	
        	}
        	
        	
            
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
        	$thumb_url = iconv("UTF-8", "GBK", $model->thumb_url);
        	$img_original = iconv("UTF-8", "GBK", $model->img_original);
        	$img_url = iconv("UTF-8", "GBK", $model->img_url);
        	
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
//         	var_dump(pathinfo($model->img_original));
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
}
