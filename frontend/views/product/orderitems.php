<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use yii\helpers\StringHelper;
use frontend\models\Productimages;
use frontend\models\Product;
use frontend\models\Orderitems;
use yii\bootstrap4\ActiveForm;
use common\models\User;

$orders= Orderitems::find()->joinWith('order')->joinWith('user')->joinWith('product')->all();

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
            <span>Orders</span>
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
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Cans</th>
                    <th>Discount Offered</th>
                    <th>Total Amount</th>
                    <th>Created At</th>
                    <th>Product Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($orders as $use) {?> 
                  <tr>
                    <td> <?=$use->order->orderId ?> </td>
                    <td> <?=$use->user->username ?> </td>
                    <td> <?=$use->product->productName ?> </td>
                    <td> <?=$use->quantity ?> </td>
                    <td> <?=$use->product->unitPrice ?> </td>
                    <td> <?=$use->withCan ?> </td>
                    <td> <?=$use->product->discount ?> on each </td>
                    <td> <?=$use->order->totalAmount ?> </td>
                    <td> <?=$use->order->createdAt ?> </td><td> 
                      <img src="<?= Yii::$app->request->baseUrl.'/backend/'.$use->product->imagePath ?>" class="center" width="50px"  alt="Product Image"> </td>
                    <td>
                     <a href="#"><button type="button" class="badge badge-pill btn-primary px-3 py-2 ">Edit</button></a>
                     <a href="#" baseUrl="<?= Yii::$app->request->baseUrl?>" id="<?=$use->product->productId?>" class="badge badge-pill btn-danger px-3 py-2 deletse"> Delete </a>

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