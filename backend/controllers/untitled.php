<?php

namespace backend\controllers;

use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\models\Cans;
use backend\models\ProductImages;

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
                    'delete' => ['POST'],
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
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
    if ($model->load(Yii::$app->request->post())){
            $model = ['Product'=>['productName'=>$productName,'quantity'=>$quantity,'unitPrice'=>$unitPrice,'discount'=>$discount,'createdBy'=>yii::$app->user->id]];
            $cans = ['Cans'=>['productId'=>$productId,'amount'=>$amount,'type'=>$type,'createdBy'=>yii::$app->user->id]];

            $model->save();

     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $image = new ProductImages();
        $can = new Cans();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($this->saveCan($model->productId,Yii::$app->request->post()['Cans'])){
                return $this->redirect(['product/index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'image'=>$image,
            'can'=>$can,
        ]);
    }
    public function saveCan($productId,$candata)
    {
        $model = new \frontend\models\Cans();

        if($model->load(["Cans"=>['type'=>$candata['type'], 'amount'=>$candata['amount'],]]))
        {   
            $model->productId = $productId;
            $model->save();

             if($this->saveImage($model->productId,Yii::$app->request->post()['ProductImages'])){
                return $this->redirect(['product/index']);
                }
            }
        return $this->render('cans', [
            'model' => $model,
        ]);
    }
    /**
     * 
     * @param  $productId
     * @param  $imagedata
     */
    public function saveImage($productId,$imagedata){
        
        $model = new Productimages();
                
        if($model->load(["ProductImages"=>['imagePath'=>$imagedata['imagePath']]]))
        {
        //generates images with unique names
        $imageName = bin2hex(openssl_random_pseudo_bytes(10));
        $model->imagePath = UploadedFile::getInstance($model, 'imagePath');
        //saves file in the root directory
         $model->imagePath->saveAs('uploads/'.$imageName.'.'.$model->imagePath->extension);
       //save in the db
            $model->imagePath='uploads/'.$imageName.'.'.$model->imagePath->extension;
            $model->productId = $productId;

            if($model->save()){
                return true;
            }
        }
        return false;
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
        $image= new ProductImages();
        $can = new Cans();
        
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            /*
            if($this->saveCan($model->productId,Yii::$app->request->post()['Cans'])){*/
                return $this->redirect(['product/index']);
            
        }

        return $this->render('update', [
            'model' => $model,
            'image'=>$image,
            'can'=>$can,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTrash($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        if (($model = Cans::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
