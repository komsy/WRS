<?php

namespace frontend\controllers;


use Yii;
use frontend\models\Cans;
use frontend\models\Orders;
use frontend\models\Deliveryrecord;

class ProductController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }  
    public function actionAddorder($userId,$productId,$withCan,$quantity,$totalAmount)
    {
        $checkorder = Orders::find()->where(['userId'=>$userId])->andWhere(['productId'=>$productId])->asArray()->one();
        if(empty($checkorder)){
            if($this->createorder($userId,$productId,$withCan,$quantity,$totalAmount)){
                return json_encode('true');
            }
            
        }else {
            $this->updateorders($checkorder['orderId'],$userId,$productId,$withCan,$quantity,$totalAmount);
        }
    }
    
    public function createOrder($userId,$productId,$withCan,$quantity,$totalAmount)
    {
        $model = New Orders();
         if($withCan == "1" ){
            $withCan = $quantity+$model->withCan;
            $withCa = Cans::find()->select('amount')->where('productId=:productId')->addParams([':productId' => $productId])->one(); 
            $totalAmount = ($withCa->amount)*$quantity+$totalAmount;
            $data = ['Orders'=>['userId'=>$userId,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'totalAmount'=>$totalAmount,'orderStatus'=>'New']];
            
                if($model->load($data)){ 
                    /*var_dump($model); exit();*/
                    $model->save();
                    return $this->redirect(['product/index']);
                 }
                return false;
            }
            else{
                $data = ['Orders'=>['userId'=>$userId,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'totalAmount'=>$totalAmount,'orderStatus'=>'New']];
                if($model->load($data)){ 
                   /* var_dump($model); exit();*/
                    $model->save();
                    return $this->redirect(['product/index']);
                 
                }
                return false;
            }   
        }           
    public function updateOrders($orderId,$userId,$productId,$withCan,$quantity,$totalAmount)
    {/*
        var_dump($orderId,$userId,$productId,$withCan,$quantity,$totalAmount); exit();*/
        $id = $orderId;
        $model = $this->findModel($id);
        if($withCan == "1" ){
            $withCa = Cans::find()->select('amount')->where('productId=:productId')->addParams([':productId' => $productId])->one();
            $totalAmount = $model->totalAmount+($withCa->amount*$quantity)+$totalAmount;
            $withCan = $quantity+$model->withCan;
            $quantity = $model->quantity+$quantity;
            
            $data = ['Orders'=>['userId'=>$userId,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'totalAmount'=>$totalAmount,'orderStatus'=>'Updated']];
                if($model->load($data)){  /*
                    var_dump($model); exit(); */         
                    $model->save();                   
                    return $this->redirect(['product/index']);
                 }
                return false;
            }
            else{
                $withCan = $model->withCan;
                $quantity = $model->quantity+$quantity;
                $totalAmount = $model->totalAmount+$totalAmount; 
                $data = ['Orders'=>['orderId'=>$orderId,'userId'=>$userId,'productId'=>$productId,'withCan'=>$withCan,'quantity'=>$quantity,'totalAmount'=>$totalAmount,'orderStatus'=>'Updated']];
                
           if($model->load($data)){            
                    $model->save();                   
                    return $this->redirect(['product/index']);
                 }
            return false;
        } 
    }
    public function actionUpdate($productId,$orderId,$quantity,$price)
    {
        $id = $orderId;
        $model = New Orders();
        if (($model = Orders::findOne($id)) !== null) {
        $checkcans = Orders::find()->select('withCan')->where(['userId'=>yii::$app->user->id])->andWhere(['productId'=>$productId])->one();
        if(empty($checkcans)){
            $quantity = $quantity;
            $totalAmount = $quantity*$price;
            $data = ['Orders'=>['quantity'=>$quantity, 'totalAmount'=>$totalAmount]];
                var_dump($data); exit();
                if ($model->load($data)){ 
                    $model->save();
                    return $this->redirect(['product/orders']);
                }
            }
            else{
                $withCa = Cans::find()->where('productId=:productId')->addParams([':productId' => $productId])->one();
                $totalAmount = ($withCa->amount*$checkcans->withCan) + ($quantity*$price);
                $quantity = $quantity;
                $data = ['Orders'=>['quantity'=>$quantity, 'totalAmount'=>$totalAmount]];
                
                if ($model->load($data)){ 
                    $model->save();
                    return $this->redirect(['product/orders']);
                }
            }
        }

        return false;
    }
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionOrderitems()
    {
        return $this->render('orderitems');
    }  
    public function actionCut($id)
   {
       $this->findModel($id)->delete();
       return $this->redirect(['orders']);
   }  
  
   /* public function actionOrders()
    {
        $model = new Deliveryrecord();

        if ($model->load(Yii::$app->request->post())) {
                
             $model->save();
            $this->deposit($model->id,$model->contactNumber);
            }

        return $this->render('orders', [
            'model' => $model,
        ]);
    }*/
    /** Mpesa intergration
     *
     * @return void|unknown
     */
    public function actionOrders()
    {
        $model = new \frontend\models\Deposit();
        
        if (\Yii::$app->request->post()) {
            $response = $this->pay(\Yii::$app->request->post()['Deposit']);
            $this->processRespose($response,\Yii::$app->request->post());

        return $this->redirect(['product/orders']);
        }
        
        return $this->render('orders', [
            'model' => $model,
        ]);
    }
    public function pay($postData){
        $mpesa_api = new MpesaApi();
       // var_dump($postData); exit();
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = $postData['transAmount'];
        $PhoneNumber = $postData['phoneCode'].$postData['mpesaNumber'];
        $PartyA = $postData['phoneCode'].$postData['mpesaNumber'];
        $PartyB = 174379;
     //   $UserId = $postData['userId'];
        $CallBackURL = 'https://a41737270d1c.ngrok.io/shop/xyz/confirm?token=KUstudents51234567qwerty';
        $AccountReference =  '3Wies';
        $TransactionDesc = '3Wies';
        
        
        
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
            'ConsumerKey' => 'ITWg7obHCx5JDkvL7QwmJ5czvWB8EtqU',
            'ConsumerSecret' => 'zxhDdSRGi208JYZo',
        );
        
        $response = $mpesa_api->call($api, $configs, $parameters);
        return $response['Response']['access_token'];
        
    } 
    public function processRespose($response,$postData) {
        $model = new \frontend\models\Deposit();
        if (array_key_exists('errorCode', $response['Response'])) {
            $model->load($postData);
            $model->save();
            $Msg = '<div class="alert alert-danger alert-dismissable" role="alert">
                    <h3>THE FOLLOWING ERROR HAS ACCURED WHILE TRYING TO PROCESS YOUR REQUEST</h3>
                     <h5> ERROR CODE: '.$response['Response']['errorCode'].'</h5>
                     <h6>'.$response['Response']['errorMessage'].'</h6><h6>For more information Please Contact Support Via: 0704081087</h6>
                    </div>';
            \Yii::$app->session->setFlash('error', $Msg);
            $this->redirect(['site/index']);
        }else{
            $model->load($postData);
            if (array_key_exists('MerchantRequestID', $response['Response'])) {
                $model->MerchantRequestId = $response['Response']['MerchantRequestID'];
                $this->saveRequestData($response,$postData['Deposit']['orderId']);
            }
            $model->save();
            $Msg = '<div class="alert alert-success alert-dismissable" role="alert">
                            <h5> '.$response['Response']['CustomerMessage'].'</h5>
                          </div>';
            \Yii::$app->session->setFlash('success', $Msg);
            $this->redirect(['site/index']);
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


        