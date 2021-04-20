<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Product;
use frontend\models\Orderitems;
use frontend\models\Orders;
use yii\bootstrap4\ActiveForm;

$orders= Orderitems::find()->joinWith('order')->where(['orders.userId'=>Yii::$app->user->id])->joinWith('cans')->joinWith('product')->all();
?>

<script src="https://use.fontawesome.com/c560c025cf.js"></script>
<div class="container">
   <div class="card shopping-cart">
        <div class="card-header bg-dark text-light">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            Shipping cart
            <a href="<?= Url::to(['product/index'])?>" class="btn btn-outline-info btn-sm float-right">Continue shopping</a>
            <div class="clearfix"></div>
        </div>
        <div class="card-body">
                    <!-- PRODUCT -->
            <div class="row">

            <?php foreach ($orders as $listing ) {?>            
                <div class="col-md-2">
                    <img class="img-responsive" src="<?= Yii::$app->request->baseUrl.'/backend/'.$listing->product->imagePath ?>" alt="prewiew" width="50" height="50">
                </div>
                <div class="col-md-4 text-center">
                    <h4 class="product-name"><strong><?=$listing->product->productName ?></strong></h4>
                    <h4>
                        <small>With <?=$listing->withCan?> cans </small>
                    </h4>
                </div>
                <div class="col-md-4">
                     <div class="row">
                    <div class="col-md-6 text-md-right" style="padding-top: 5px">
                        <h6><strong>Ksh. <?=$listing->product->unitPrice-$listing->product->discount ?></strong></h6>
                    </div>
                    <div class="col-md-6">
                          Quant:  <?=$listing->quantity ?>
                    </div>
                    
                </div>
                </div>
                <div class="col-md-2">
                    <h4 class="product-name"><strong><?=$listing->total?></strong></h4>
                </div>
            <!-- END PRODUCT -->

             <br>
            <?php } ?>
            </div> 
            <div class="row shadow card-footer">
                <div class="col-md-2"> </div>
                <div class="col-md-6">
                  <h1>Total Amount: Ksh <?=$listing->order->totalAmount?>  </h1>         
                </div>
                <div class="col-md-4">
                    <!--  <a href="#" baseUrl="<?= Yii::$app->request->baseUrl?>" productid="<?= $listing->product->productId?>" total="<?=$listing->order->totalAmount?>" userid="<?= Yii::$app->user->id?>" class="btn btn-lg btn-success pull-right text-uppercase addorder"> Checkout </a> -->
                    
                </div>
            </div>
        </div>
    </div>
</div>
