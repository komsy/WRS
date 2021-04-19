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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
  /*  public function actionCreate()
    {
        $model = new Product;
        $model1 = new Cans;

        $roles = Roles::model()->findAll();

        if(isset($_POST['Product']))
        {
            $model->attributes = $_POST['Product'];
            $model->productName = crypt($model->productName, 'salt');
            $model->datecreated = new CDbExpression('NOW()');
            $model->save();

            $model1->attributes = $_POST['Users']['emailaddress'];
            $model1->fer_users_id = $model->id;
            $model1->save();

            $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'user'=>$model,
            'email'=>$model1,
            'roles'=> $roles
        ));
    }*/
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
    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
/*    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $can = new Cans();
        
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            if($this->saveCan($model->productId,Yii::$app->request->post()['Cans'])){
                return $this->redirect(['product/index']);
            
        }

        return $this->render('update', [
            'model' => $model,
            'can'=>$can,
        ]);
    }
*/
    public function actionUpdate($id)

    {

        $model=Product::model()->findByPk($id);

        $can=Cans::model()->findByAttributes(array('canId'=>$model->id));

        // Uncomment the following line if AJAX validation is needed

        // $this->performAjaxValidation($model);

        if(isset($_POST['Product']) && isset($_POST['Cans']))

        {

            $model->attributes=$_POST['Product'];
            $can->attributes=$_POST['Cans'];

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
          /* if($model->save()){
                    $this->redirect(['model1' => $model->productId]);
                }*/
            //saving can data
            $can->productId= $model->productId;
            $can->type = $can->type;
            $can->amount = $can->amount;
            
            
            $model->save();
            $model1->save();
        }
        return $this->render('update', [
            'model'=>$model,
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
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
