<?php

namespace frontend\controllers;


use Yii;
use yii\filters\VerbFilter;
use frontend\models\Cans;
use frontend\models\Product;
use common\models\User;
use frontend\models\Pos;

class CashierController extends \yii\web\Controller
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

    public function actionIndex()
    { 
        $model = New Pos();
        
        if($model->load(Yii::$app->request->post())) {
        $prod = Product::find()->select('productName')->where('productId=:productName')->addParams([':productName' => $model['productName']])->one(); 
        $total = (100-$model->discountPercentage)/100*$model->price*$model->quantity;
        $model->productName = $prod->productName;
        $model->quantity = $model->quantity;
        $model->price = $model->price;
        $model->discountPercentage = $model->discountPercentage;
        $model->createdBy = $model->createdBy;
        $model->totalAmount = $total;
        $model->status = '0';
    
         $model->save();
            return $this->redirect(['cashier/index']);   
                   }
            return $this->render('index', [
            'model' => $model,
        ]);
    }
      public function actionDeleted()
    {
        return $this->render('deleted');
    } 

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $totalAmount = (100-$model->discountPercentage)/100*$model->price*$model->quantity;
         $data = ['Pos'=>['productName'=>$model->productName,'quantity'=>$model->quantity,'price'=>$model->price,'discountPercentage'=>$model->discountPercentage,'totalAmount'=>$totalAmount,'status'=>0,'createdBy'=>$model->createdBy]];

            if ($model->load($data)){ 
                $model->save();
            return $this->redirect(['cashier/index']);
        }

        return false;
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
       $model = $this->findModel($id);
        $totalAmount = (100-$model->discountPercentage)/100*$model->price*$model->quantity;
         $data = ['Pos'=>['productName'=>$model->productName,'quantity'=>$model->quantity,'price'=>$model->price,'discountPercentage'=>$model->discountPercentage,'totalAmount'=>$totalAmount,'status'=>1,'createdBy'=>$model->createdBy]];

            if ($model->load($data)){ 
                $model->save();
            return $this->redirect(['cashier/index']);
        }

        return false;
    }

    protected function findModel($id)
    {
        if (($model = Pos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



  

}


        