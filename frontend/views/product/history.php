<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use yii\helpers\StringHelper;
use frontend\models\Orders;
use frontend\models\Orderitems;
use frontend\models\Product;
use frontend\models\Deliveryrecord;
use yii\bootstrap4\ActiveForm;
use common\models\User;

$orders= Deliveryrecord::find()->where(['deliveryrecord.userId'=>Yii::$app->user->id])->joinWith('delivery')->joinWith('order')->joinWith('user')->all();
$totalamount = Orderitems::find()->sum('total');
?>
<!--Main layout-->
 <div class="content-wrapper">
    <section class="content pt-4">
    <section class="mb-4">
      <div class="card">
        <div class="card-body d-sm-flex justify-content-between">

          <h4 class="mb-2 mb-sm-0 pt-1">
            <a href="<?= Url::to(['site/index'])?>" target="_blank">Home Page</a>
            <span>/</span>
            <span>My Order History</span>
            </h4>         
        </div>
      </div>
    </section>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Delivery ID</th>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Total Amount</th>
                    <th>Order Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($orders as $use) {?> 
                    
                  <tr>                    
                    <td> <?=$use->delivery->location ?> </td>
                    <td> <?=$use->orderId ?> </td>
                    <td> <?=$use->fullName ?> </td>
                    <td> <?=$totalamount?> </td>
                    <td class="text-center"> 
                     <?php if($use->deliveryStatus == 'Pending') 
                        echo '<label class="py-2 px-3 badge btn-danger">Pending </label>';                      
                        if($use->deliveryStatus == 'Processing')
                        echo '<label class="py-2 px-3 badge btn-primary">Processing </label>';                     
                        elseif($use->deliveryStatus == 'Delivered')
                        echo '<label class="py-2 px-3 badge btn-success">Delivered </label>';  
                      ?>
                    </td>
                                        
                  </tr>               
                 <?php } ?>
                </tbody>
              </table>
              <!-- pagination  -->               
              </div>
            </div>
          </div>
        </div>
<!--Main layout-->
</section>
</div> 