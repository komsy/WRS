<?php

namespace frontend\controllers;


use Yii;
use frontend\models\Cans;
use frontend\models\Orders;
use frontend\models\Orderitems;

class ProductController extends \yii\web\Controller
{
    public function actionIndex()
    { 
        $model = New Orderitems();
        if ($model->load(Yii::$app->request->post())) {
            /*var_dump($model); exit();*/
         $model->save();
            return $this->redirect(['site/index']);   
                   }
            return $this->render('index', [
            'model' => $model,
        ]);
    }
    
    public function actionAddorder($productId,$userId,$quantity,$total,$withCan)
    {
        $checkorder = Orders::find()->where(['userId'=>$userId])->andWhere(['orderStatus'=>'New'])->asArray()->one();
        if(empty($checkorder)){
            if($this->createorder($userId,$productId,$quantity,$total,$withCan)){
                return json_encode('true');
            }
            
        }else {
            $this->createOrdersItems($checkorder['orderId'],$productId,$quantity,$total,$withCan,$userId);
        }
    }
    
    public function createOrder($userId,$productId,$quantity,$total,$withCan){
        $model = New Orders();
        $data = ['Orders'=>['userId'=>$userId,'totalAmount'=>$total,'orderStatus'=>'New','createdBy'=>yii::$app->user->id]];
        if($model->load($data) && $model->save()){
            $this->createordersItems($model->orderId,$productId,$quantity,$total,$withCan,$userId);
        }
        return false;
    }

    public function createOrdersitems($orderId,$productId,$quantity,$total,$withCan,$userId)
    {
        $checkorderi = Orderitems::find()->where(['productId'=>$productId])->one();
        $model = New Orderitems();
        if(empty($checkorderi)){

            if($withCan == "1" ){
            $withCan = $quantity+$model->withCan;
            $withCa = Cans::find()->select('amount')->where('productId=:productId')->addParams([':productId' => $productId])->one(); 
            $total = ($withCa->amount)*$quantity+$total;
            $data = ['Orderitems'=>['orderId'=>$orderId,'userId'=>$userId,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'total'=>$total]];
            /*var_dump($data); exit();*/
                if($model->load($data) && $model->save()){
                    $total = Orderitems::find()->joinWith('order')->where('orderitems.orderId=:orderId')->addParams([':orderId' => $orderId])->sum('total'); 
                    return $this->redirect(['product/index']);
                    /*$this->updateorder($orderId,$total,$userId);*/
                 }
                return false;
            }
            else{
                $data = ['Orderitems'=>['orderId'=>$orderId,'userId'=>$userId,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'total'=>$total]];
                /*var_dump($data); exit();*/
                if($model->load($data) && $model->save()){
                    $total = Orderitems::find()->joinWith('order')->where('orderitems.orderId=:orderId')->addParams([':orderId' => $orderId])->sum('total'); 
                    return $this->redirect(['product/index']);
                   /* var_dump($total); exit();*/
                    /*$this->updateorder($orderId,$total,$userId);*/
                }
                return false;
            }   
        }           
            
        else {
            $total = $checkorderi->total+$total;
            $this->updateorderitems($checkorderi['orderItemsId'],$orderId,$userId,$productId,$quantity,$total,$withCan,$userId);
        }
    }
/*    public function createOrderitems($orderId,$productId,$quantity,$total,$withCan,$userId)
    {
        $model = New Orderitems();
        
        if($withCan == "1" ){
            $withCan = Cans::find()->select('amount')->where('productId=:productId')->addParams([':productId' => $productId])->one(); 
            $total = $withCan->amount+$total;
            $data = ['Orderitems'=>['orderId'=>$orderId,'productId'=>$productId,'withCan'=>$withCan->amount,'quantity'=>$quantity,'total'=>$total]];
            
                if($model->load($data) && $model->save()){
                    $total = Orderitems::find()->joinWith('order')->where('orderitems.orderId=:orderId')->addParams([':orderId' => $orderId])->sum('total'); 
                    $this->updateorder($orderId,$total,$userId);
                 }
                return false;
            }
            else{
                $data = ['Orderitems'=>['orderId'=>$orderId,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'total'=>$total]];
           
            if($model->load($data) && $model->save()){
                $total = Orderitems::find()->joinWith('order')->where('orderitems.orderId=:orderId')->addParams([':orderId' => $orderId])->sum('total'); 
               
                $this->updateorder($orderId,$total,$userId);
            }
            return false;
        }   
    } 
*/
    public function updateOrder($orderId,$total,$userId)
    {
        $id = $orderId;
        if (($model = Orders::findOne($id)) !== null) {
        $data = ['Orders'=>['userId'=>$userId,'totalAmount'=>$total,'orderStatus'=>'Updated','createdBy'=>yii::$app->user->id]];
            if ($model->load($data)){ 
                $model->save();
                return $this->redirect(['product/index']);
            }
        }
        return false;
    }
    public function updateOrderItems($orderItemsId,$orderId,$userId,$productId,$quantity,$total,$withCan)
    {
        $id = $orderItemsId;
        $model = $this->findModel($id);
        if($withCan == "1" ){
            $withCa = Cans::find()->select('amount')->where('productId=:productId')->addParams([':productId' => $productId])->one();
            $total = ($withCa->amount)*$quantity+$total;
            $withCan = $quantity+$model->withCan;
            $quantity = $model->quantity+$quantity;
            
            $data = ['Orderitems'=>['orderId'=>$orderId,'userId'=>$userId,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'total'=>$total]];
                if($model->load($data)){

            
            $model->save();
                    $total = Orderitems::find()->joinWith('order')->where('orderitems.orderId=:orderId')->addParams([':orderId' => $orderId])->sum('total'); /*
                    return $this->redirect(['product/index']); */
                    $this->updateorder($orderId,$total,$userId);
                 }
                return false;
            }
            else{
                $withCan = $model->withCan;
                $quantity = $model->quantity+$quantity;
            
                $data = ['Orderitems'=>['orderId'=>$orderId,'userId'=>$userId,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'total'=>$total]];
           /*var_dump($data); exit();*/
            if($model->load($data) && $model->save()){
                $total = Orderitems::find()->joinWith('order')->where('orderitems.orderId=:orderId')->addParams([':orderId' => $orderId])->sum('total'); /*
               return $this->redirect(['product/index']); */
                $this->updateorder($orderId,$total,$userId);
            }
            return false;
        } 
    }
    protected function findModel($id)
    {
        if (($model = Orderitems::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    public function actionOrders()
    {
        return $this->render('orders');
    } 
    public function actionOrderitems()
    {
        return $this->render('orderitems');
    }    
  
}


        