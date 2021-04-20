<?php

namespace backend\controllers;

use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\models\Pos;
use backend\models\Cans;
use backend\models\ProductImages;
use yii\base\Model;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Product();

        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product;

        // Uncomment the following lines if AJAX validation is needed
         /*$this->performAjaxValidation($model);
         $this->performAjaxValidation($model1);
    */
        if(isset($_POST['Product']))
            {
            $model->attributes = $_POST['Product'];

            $model->productName = $model->productName;
            $model->quantity = $model->quantity;
            $model->unitPrice = $model->unitPrice;
            $model->discount = $model->discount;

            //generates images with unique names
            $imageName = bin2hex(openssl_random_pseudo_bytes(10));
            $model->imagePath = UploadedFile::getInstance($model, 'imagePath');
            //saves file in the root directory
             $model->imagePath->saveAs('uploads/'.$imageName.'.'.$model->imagePath->extension);
           //save in the db
                $model->imagePath='uploads/'.$imageName.'.'.$model->imagePath->extension;
            $model->imagePath = $model->imagePath;
          $model->save();


            return $this->redirect(['product/index']);
        }
        return $this->render('create', [
                'model'=>$model,
            ]);
    }   

    public function actionOrders()
    {
        return $this->render('orders');
    } 
    public function actionPos()
    {
        return $this->render('pos');
    }
    public function actionDeleted()
    {
        return $this->render('deleted');
    }
    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
           if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['product/index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $this->findModel($id)->delete();

        return $this->redirect(['product/index']);
    }

    public function actionDeletd($id)
    {
        if (($model = Pos::findOne($id)) !== null){
            $model->delete();
        }

        return $this->redirect(['product/pos']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
