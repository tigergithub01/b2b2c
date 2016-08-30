<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\b2b2c\SheetType;
use app\models\b2b2c\SheetTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\di\ServiceLocator;
use app\modules\admin\common\controllers\BaseAuthController;
/**
 * SheetTypeController implements the CRUD actions for SheetType model.
 */
class SheetTypeController extends BaseAuthController
{
    /**
     * @inheritdoc
     */
    /* public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
//                 	'index' => ['POST'],
                ],
            ],
        ];
    } */

    /**
     * Lists all SheetType models.
     * @return mixed
     */
    public function actionIndex()
    {
//         Yii::$app->mailer->compose() ->setFrom('from@domain.com') ->setTo($form->email) ->setSubject($form->subject) ->setTextBody('Plain text content') ->setHtmlBody('HTML content') ->send();
    	$searchModel = new SheetTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        /* View路径的几种方式  */
       /*  return $this->render("@app/views/site/index", [
        		'searchModel' => $searchModel,
        		'dataProvider' => $dataProvider,
        ]); */
        
        /* return $this->render("@app/modules/admin/views/sheet-type/index", [
        		'searchModel' => $searchModel,
        		'dataProvider' => $dataProvider,
        ]); */
        
//         var_dump(Yii::$aliases);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SheetType model.
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
     * Creates a new SheetType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SheetType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            /* return $this->redirect(['view', 'id' => $model->id]); */
        	return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SheetType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
        	return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SheetType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionTest(){
    	/* //yii增加匿名
    	Yii::setAlias('@foo', '/path/to/foo');
    	var_dump(Yii::$aliases);
    	
    	//service locator
    	$locator = new ServiceLocator;
    	$components = $locator->getComponents();
    	var_dump($components);
    	
    	//why service locator not work?
    	var_dump((new \yii\di\ServiceLocator())->has("db"));
    	var_dump($locator->has("db"));
    	
    	//print components
    	var_dump(Yii::$app->components); */
    	
    	/* $password = "tiger";
    	$hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    	var_dump($hash);
    	if (Yii::$app->getSecurity()->validatePassword($password, $hash)) {
    		// all good, logging user in
    		var_dump("all good, logging user in");
    	} else {
    		// wrong password
    		var_dump("wrong password");
    	} */
    	
    	
    	/* $pwd = Yii::$app->getSecurity()->encryptByPassword("tiger", "qqxsdsdsd");
    	var_dump($pwd); */
    	
//     	var_dump(md5("tiger"));
// 		var_dump("test");
		\Yii::info("test");
// 		1/0;
    	
    }

    /**
     * Finds the SheetType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SheetType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SheetType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
