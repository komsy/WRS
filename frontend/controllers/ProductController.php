<?php

namespace frontend\controllers;

use Yii;
use common\xyz\MpesaApi;
use yii\web\Controller;
use frontend\models\Cans;
use frontend\models\Orderitems;
use frontend\models\Product;
use frontend\models\Deposit;
use frontend\models\Orders;
use frontend\models\Deliveryrecord;

class ProductController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/index']);
        }
        else{
        return $this->render('index');
    }
    }  
    public function actionAddorder($userId,$productId,$withCan,$quantity,$total)
    {
        $checkorder = Orders::find()->where(['userId'=>$userId])->andWhere(['orderStatus'=>'New'])->asArray()->one();
        if(empty($checkorder)){
            if($this->createorder($userId,$productId,$withCan,$quantity,$total)){
                return json_encode('true');
            }
            
        }else {
            $this->createorderitems($checkorder['orderId'],$userId,$productId,$withCan,$quantity,$total);
        }
    }
    
    public function createOrder($userId,$productId,$withCan,$quantity,$total){
        $model = New Orders();
        $data = ['Orders'=>['userId'=>$userId,'orderStatus'=>'New']];
        /*var_dump($data); exit();*/
        if($model->load($data) && $model->save()){
            $this->createorderitems($model->orderId,$userId,$productId,$withCan,$quantity,$total);
        }
        return false;
    }

    public function createOrderItems($orderId,$userId,$productId,$withCan,$quantity,$total)
    {
        $model = New Orderitems();
        $checkorderi = Orderitems::find()->where(['productId'=>$productId])->asArray()->one();
        if(empty($checkorderi)){

         if($withCan == "1" ){
            $withCan = $quantity+$model->withCan;
            $withCa = Cans::find()->select('amount')->where('productId=:productId')->addParams([':productId' => $productId])->one(); 
            $total = ($withCa->amount)*$quantity+$total;
            $data = ['Orderitems'=>['orderId'=>$orderId,'userId'=>yii::$app->user->id,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'total'=>$total]];

                if($model->load($data)){ 
                    $model->save();
                    return $this->redirect(['product/index']);
                 }
                return false;
            }
            else{
                $data = ['Orderitems'=>['orderId'=>$orderId,'userId'=>yii::$app->user->id,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'total'=>$total]];
                if($model->load($data)){ 
                    /*var_dump($model); exit();*/
                    $model->save();
                    return $this->redirect(['product/index']);
                 
                }
                return false;
            }   
        } else {
            $this->updateorderitems($orderId,$userId,$productId,$withCan,$quantity,$total);
        }
    }          
    public function updateOrderItems($orderId,$userId,$productId,$withCan,$quantity,$total)
    {
        /*var_dump($orderId,$productId,$withCan,$quantity,$total); exit();
         */$checkorders = Orders::find()->where(['orderId'=>$orderId])->andWhere(['orderStatus'=>'New'])->asArray()->one();
        
       if(empty($checkorders)){
            $this->createitems($orderId,$userId,$productId,$withCan,$quantity,$total);
            }
            else{
                    $id = $orderId;
                    $model = Orderitems::find()->where('productId=:productId')->addParams([':productId' => $productId])->one();
                    if($withCan == "1" ){
                    $withCa = Cans::find()->select('amount')->where('productId=:productId')->addParams([':productId' => $productId])->one();
                    $total = $model->total+($withCa->amount*$quantity)+$total;
                    $withCan = $quantity+$model->withCan;
                    $quantity = $model->quantity+$quantity;
                    
                    $data = ['Orderitems'=>['orderId'=>$orderId,'userId'=>yii::$app->user->id,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'total'=>$total]];
                    /*var_dump($data); exit();*/
                        if($model->load($data)){  
                           /* var_dump($model); exit();*/          
                            $model->save();                   
                            return $this->redirect(['product/index']);
                         }
                        return false;
                    }
                    else{
                        $withCan = $model->withCan;
                        $quantity = $model->quantity+$quantity;
                        $total = $model->total+$total; 
                        $data = ['Orderitems'=>['orderId'=>$orderId,'userId'=>yii::$app->user->id,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'total'=>$total]];
                       /*var_dump($data); exit();*/ 
                   if($model->load($data)){            
                            $model->save();                   
                            return $this->redirect(['product/index']);
                         }
                    return false;
                } 
        }
    }
     public function createItems($orderId,$userId,$productId,$withCan,$quantity,$total)
    {/*
        var_dump($orderId,$userId,$productId,$withCan,$quantity,$total); exit();*/
        $model = New Orderitems();
         if($withCan == "1" ){
            $withCan = $quantity+$model->withCan;
            $withCa = Cans::find()->select('amount')->where('productId=:productId')->addParams([':productId' => $productId])->one(); 
            $total = ($withCa->amount)*$quantity+$total;
            $data1 = ['Orderitems'=>['orderId'=>$orderId,'userId'=>$userId,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'total'=>$total]];
                if($model->load($data1)){ 
            /*var_dump($model); exit();*/
                    $model->save();
                    return $this->redirect(['product/index']);
                 }
                return false;
            }
            else{
                $data = ['Orderitems'=>['orderId'=>$orderId,'userId'=>$userId,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'total'=>$total]];
                if($model->load($data)){ 
                    /*var_dump($model); exit();*/
                    $model->save();
                    return $this->redirect(['product/index']);
                 
                }
                return false;
            }   
        
    }   
    public function actionUpdate($productId,$orderItemsId,$orderId,$quantity,$price)
    {
        $id = $orderItemsId;
        $model = New Orderitems();
        if (($model = Orderitems::findOne($id)) !== null) {
        $checkcans = Orderitems::find()->select('withCan')->where(['productId'=>$productId])->andWhere(['orderId'=>$orderId])->one();
        if(empty($checkcans)){
            $quantity = $quantity;
            $total = $quantity*$price;
            $data = ['Orderitems'=>['quantity'=>$quantity, 'total'=>$total]];
                /*var_dump($data); exit();*/
                if ($model->load($data)){ 
                    $model->save();
                    return $this->redirect(['product/orders']);
                }
            }
            else{
                $withCa = Cans::find()->where('productId=:productId')->addParams([':productId' => $productId])->one();
                $total = ($withCa->amount*$checkcans->withCan) + ($quantity*$price);
                $quantity = $quantity;
                $data = ['Orderitems'=>['quantity'=>$quantity, 'total'=>$total]];
                
                if ($model->load($data)){ 
                    /*var_dump($model); exit();*/
                    $model->save();
                    return $this->redirect(['product/orders']);
                }
            }
        }

        return false;
    }
    public function Minus($productId,$quantity)
    {
        $id = $productId;
        $model = New Product();
        if (($model = Product::findOne($id)) !== null) {
        $checkid = Product::find()->select('quantity')->where(['productId'=>$productId])->one();
        if(empty($checkid)){
            $Msg = '<div class="alert alert-danger alert-dismissable" role="alert">
                    <h3>The selected product is out of Stock!</h3>
                    <h4>Thank You!</h4>
                     
                    </div>';
            \Yii::$app->session->setFlash('error', $Msg);
            $this->redirect(['product/orders']);
            }
            else{
                $withCa = Cans::find()->where('productId=:productId')->addParams([':productId' => $productId])->one();
                $quantity = $checkid->quantity-$quantity;
                $data = ['Product'=>['quantity'=>$quantity]];
                
                if ($model->load($data)){ 
                    $model->save();
                    return $this->redirect(['product/orders']);
                }
            }
        }

        return false;
    }
    public function actionCashier($id)
    {
        $model = New Deliveryrecord();
        if (($model = Deliveryrecord::findOne($id)) !== null) {
            $data = ['Deliveryrecord'=>['deliveryStatus'=>"Processing"]];
                /*var_dump($data); exit();*/
                if ($model->load($data)){ 
                    $model->save();
                    return $this->redirect(['product/orderitems']);
                }
            }

        return false;
    }
    
    protected function findModel($id)
    {
        if (($model = Orderitems::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionOrderitems()
    {
        return $this->render('orderitems');
    }  
    public function actionDetails()
    {
        return $this->render('details');
    } 
    public function actionHistory()
    {
        return $this->render('history');
    } 
    public function actionCut($id)
   {
       
        if (($model = Orders::findOne($id)) !== null) {
              $model->delete();
        }
       return $this->redirect(['orders']);
     }    
    public function actionOrders()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        else{
            $model = new Deliveryrecord();
            if ($model->load(Yii::$app->request->post())) {
                    /*var_dump($model); exit();*/
                 $model->save();
                 return $this->redirect(['product/orders']);/*
                  $this->deposit($model->id,$model->orderId,$model->totalAmount,$model->contactNumber);*/
                }

            return $this->render('orders', [
                'model' => $model,
            ]);
        }
    }
    public function actionDelivery($id,$productId,$userId,$orderId)
    {
        $model = new Deliveryrecord();
        $withCa = Deliveryrecord::find()->one(); 
            $data = ['Deliveryrecord'=>['userId'=>$userId,'orderId'=>$orderId,'deliveryId'=>$withCa->deliveryId,'fullName'=>$withCa->fullName,'address'=>$withCa->address,'postalCode'=>$withCa->postalCode,'city'=>$withCa->city,'deliveryStatus'=>'Pending']];
            
        if ($model->load($data)) {/*
                var_dump($model); exit();*/
             $model->save();/*
             return $this->redirect(['product/orders']);*/
            }

        return false;
    }

/**
     *
     * @return void|unknown
     */
    public function actionDeposit()
    {
        $model = new \frontend\models\Deposit();
        
        if (\Yii::$app->request->post()) {/*
            var_dump(\Yii::$app->request->post()); exit();*/
            $response = $this->pay(\Yii::$app->request->post()['Deposit']);
            $this->processRespose($response,\Yii::$app->request->post());
        }
        
        return $this->render('deposit', [
            'model' => $model,
        ]);
    }
/* code before saving to db
public function actionDeposit()
    {
        $model = new \frontend\models\Deposit();
        
        if (\Yii::$app->request->post()) {
            $response = $this->pay(\Yii::$app->request->post()['Deposit']);
            
            if (array_key_exists('errorCode', $response['Response'])) {
                $Msg = '<div class="alert alert-danger alert-dismissable" role="alert">
                    <h3>THE FOLLOWING ERROR HAS ACCURED WHILE TRYING TO PROCESS YOUR REQUEST</h3>
                     <h5> ERROR CODE: '.$response['Response']['errorCode'].'</h5>
                     <h6>'.$response['Response']['errorMessage'].'</h6><h6>For more information Please Contact Support Via: 0704081087</h6>
                    </div>';
                \Yii::$app->session->setFlash('error', $Msg);
               $this->redirect(['site/index']);
            }else{
                
                $Msg = '<div class="alert alert-success alert-dismissable" role="alert">
                            <h5> '.$response['Response']['CustomerMessage'].'</h5>
                          </div>';
                \Yii::$app->session->setFlash('success', $Msg);
               // var_dump($response); exit();
                 $this->redirect(['site/index']);
                
            }
            $this->redirect(['site/index']);
            
        }
        
        return $this->renderAjax('deposit/', [
            'model' => $model,
        ]);
    }
*/
    public function pay($postData){
        $mpesa_api = new MpesaApi();
       // var_dump($postData); exit();
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = $postData['transAmount'];
        $PhoneNumber = '254'.$postData['mpesaNumber'];
        $PartyA = '254'.$postData['mpesaNumber'];
        $PartyB = 174379;
     //   $UserId = $postData['userId'];
        $CallBackURL = 'https://53a3a95e9766.ngrok.io/WRS/xyz/confirm?token=KUstudents51234567qwerty';
        $AccountReference = 'Imperial'; /* $postData['details'];*/
        $TransactionDesc = 'Imperial'; /*$postData['details'];*/
        
        
        
        $configs = array(
            'AccessToken' => $this->generateToken(),
            'Environment' => 'sandbox',
            'Content-Type' => 'application/json',
            'Verbose' => 'true',
        );
        
        $api = 'stk_push';
        $LipaNaMpesaPasskey= 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $timestamp ='20'.date("ymdhis");
        $BusinessShortCode = 174379;
        
        $parameters = array(
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => base64_encode($BusinessShortCode.$LipaNaMpesaPasskey.$timestamp),
            'Timestamp' => $timestamp,
            'TransactionType' => $TransactionType,
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $PartyB,
            'PhoneNumber' =>$PhoneNumber,
            'CallBackURL' => $CallBackURL,
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionDesc,
        );
        
        $response = $mpesa_api->call($api, $configs, $parameters);
        return $response;
    }
    
    
    private function generateToken(){
        
        $mpesa_api = new MpesaApi();
        
        $configs = array(
            'Environment' => 'sandbox',
            'Content-Type' => 'application/json',
            'Verbose' => '',
        );
        
        $api = 'generate_token';
        
        $parameters = array(
            'ConsumerKey' => '9oA0eVEICr3NGOJuGUhLOQP9zBceRlvG',
            'ConsumerSecret' => 'RpfxKh2wvvxlqR5Q',
        );
        
        $response = $mpesa_api->call($api, $configs, $parameters);
        return $response['Response']['access_token'];
        
    } 
    public function processRespose($response,$postData) {
        $model = new Deposit();
        if (array_key_exists('errorCode', $response['Response'])) {
            $model->load($postData);
            /*var_dump($model); exit();*/
            $model->save();
            $Msg = '<div class="alert alert-danger alert-dismissable" role="alert">
                    <h3>THE FOLLOWING ERROR HAS ACCURED WHILE TRYING TO PROCESS YOUR REQUEST</h3>
                     <h5> ERROR CODE: '.$response['Response']['errorCode'].'</h5>
                     <h6>'.$response['Response']['errorMessage'].'</h6><h6>For more information Please Contact Support Via: 0704081087</h6>
                    </div>';
            \Yii::$app->session->setFlash('error', $Msg);
            $this->redirect(['product/index']);
        }else{
            $model->load($postData);
            if (array_key_exists('MerchantRequestID', $response['Response'])) {
                $model->MerchantRequestId = $response['Response']['MerchantRequestID'];
                $this->saveRequestData($response,$postData['Deposit']['orderId']);
            }
            $model->save();
            $Msg = '<div class="alert alert-success alert-dismissable" role="alert">
                            <h5> '.$response['Response']['CustomerMessage'].'</h5><h5>Go back to step two to complete your order</h5>
                          </div>';
            \Yii::$app->session->setFlash('success', $Msg);
            $this->redirect(['product/index']);
        }
    }
    public function saveRequestData($response,$orderId){
        
        $model = new \frontend\models\MpesaStkRequests();
        
        $model->amount = $response['Parameters']['Amount'];
        $model->phone = $response['Parameters']['PhoneNumber'];
        $model->reference = $response['Parameters']['AccountReference'];
        $model->description = $response['Parameters']['TransactionDesc'];
        $model->CheckoutRequestID = $response['Response']['CheckoutRequestID'];
        $model->MerchantRequestID = $response['Response']['MerchantRequestID'];
        $model->orderId = $orderId;
        $model->userId = \yii::$app->user->Id;
        
        $model->save();
        
        return $model;  
    }
  
}


        