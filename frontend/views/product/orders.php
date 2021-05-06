<?php 

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\User;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use frontend\models\Product;
use frontend\models\Deposit;
use frontend\models\Orders;
use frontend\models\Deliveryrecord;
use frontend\models\Orderitems;
use frontend\models\Customers;
use frontend\models\Delivery;

$orders= Orderitems::find()->where(['orderitems.userId'=>Yii::$app->user->id])->joinWith('order')->andWhere(['orderStatus'=>'New'])->joinWith('cans')->joinWith('product')->all();
$record= Deliveryrecord::find()->joinWith('delivery')->joinWith('order')->where(['deliveryrecord.userId'=>Yii::$app->user->id])->limit(1)->all();
$info = Customers::find()->where(['userId'=>Yii::$app->user->id])->all();
$order = Orders::find()->select('orderId')->where(['userId'=>Yii::$app->user->id])->where(['orderStatus'=>'New'])->one();
$total = Orderitems::find()->where(['orderitems.userId'=>Yii::$app->user->id])->joinWith('order')->andWhere(['orderStatus'=>'New'])->sum('total');
$delivery = ArrayHelper::map(Delivery::find()->all(), 'deliveryId', 'location');
$count = Orders::find()->count();

if(empty($orders)){
    ?>
    <div class="row mt-5" style="text-align: center;">
        <div class="col">
            <img class="img-responsive mb-5"  src="<?= Yii::$app->request->baseUrl ?>/img/error.png?>"  alt="prewiew" width="250" height="250">
            <h2 >Hey, You have no orders yet!</h2>
            <a href="<?= Url::to(['product/index'])?>" class="btn btn-info btn-lg ">Go back to shopping</a>
        </div>
    </div>
 <?php }else { ?>
<div class="row mt-5">
    <div class="container">
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step col-xs-4"> 
                    <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                    <p><small>Shipping cart</small></p>
                </div>
                <div class="stepwizard-step col-xs-4"> 
                    <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                    <p><small>Personal Information and Delivery</small></p>
                </div>
                <div class="stepwizard-step col-xs-4"> 
                    <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                    <p><small>Preview</small></p>
                </div>
            </div>
        </div>
         <?php $form = ActiveForm::begin(); ?>
            <div class="panel panel-primary setup-content" id="step-1">
                <div class="panel-body">
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
                                    <div class="col-md-3 text-center">
                                        <h4 class="product-name"><strong><?=$listing->product->productName ?></strong></h4>
                                        <h4>
                                            <small>With <?=$listing->withCan?> cans </small>
                                        </h4>
                                    </div>
                                    <div class="col-md-3">
                                         <div class="row">
                                        <div class="col-md-6 text-md-right" style="padding-top: 5px">
                                            <h6><strong>Ksh. <?=$listing->product->unitPrice-$listing->product->discount ?></strong></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="number" id="quantity_<?= $listing->productId?>" name="name" placeholder="Number" class="form-control" style="width:100px;" value="<?=$listing->quantity ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h4 class="product-name"><strong><?=$listing->total?></strong></h4>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#" baseUrl="<?= Yii::$app->request->baseUrl?>" orderItemsId="<?=$listing->orderItemsId?>" orderId="<?=$listing->orderId?>" productId="<?= $listing->productId?>" price="<?=$listing->product->unitPrice-$listing->product->discount ?>" class="badge badge-pill btn-success text-uppercase px-3 py-2 update"> Update </a>
                                        <a href="#" baseUrl="<?= Yii::$app->request->baseUrl?>" id="<?=$listing->orderId?>" class="badge badge-pill btn-danger px-3 py-2 cut"> Delete </a> 

                                    </div>
                                <!-- END PRODUCT -->

                                 <br>
                            <?php } ?>
                                </div> 
                            </div>
                    </div>
                    <button class="btn btn-primary nextBtn mt-5 float-right" type="button">Next</button>
                </div>
            </div>
            
            <div class="panel panel-primary setup-content" id="step-2">
             <?php if(empty($record)){
                 ?>
                <div class="container">
                    <div class="row text-center" >
                        <div class="col" > 
                            <button class="btn btn-dark view" style="width: 100%; background-color: green;"> <i class="fas fa-plus-circle"></i> Create Delivery Location</button>
                        </div>
                    </div>
                    <div class="customers">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <?= $form->field($model, 'fullName') ?>
                            </div>
                            <div class="col-md-6 col-6">
                                <?= $form->field($model, 'address') ?>
                             </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <?= $form->field($model, 'postalCode') ?>
                             </div>
                             <div class="col-md-6 col-6">
                                <?= $form->field($model, 'city') ?>
                            
                            </div>
                        </div>  
                        <div class="row">
                          <div class="col-md-6 col-6 mt-4">
                               <?= $form->field($model, 'deliveryId')->dropDownList($delivery,['prompt'=>'Select Delivery Location'])->label(false) ?> 
                            </div>
                            <div class="col-md-6 col-6">
                                <?= $form->field($model, 'orderId')->hiddenInput(['value' =>$order->orderId, 'readonly'=>true])->label(false) ?>
                            </div>
                            
                        </div>                      
                        <?= $form->field($model, 'userId')->hiddenInput(['value' =>Yii::$app->user->id, 'readonly'=>true])->label(false) ?>
                        
                    </div><!-- customers -->
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Finish'), ['class' => 'btn btn-primary nextBtn float-right"']) ?>
                    </div>
                </div>
                <?php }else { ?>
                  <div class="row">
                    <div class="card" style="width: 50%;">
                      <div class="card-body">
                    
                        <?php foreach ($record as $rec ) {?>
                          <div class="col-md-6 col-6">
                        <div class="row">
                          <div class="col-md-6">
                            <p>Full Name:</p>
                          </div>
                          <div class="col-md-6">
                            <?=$rec->fullName ?>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <p>Delivery location:</p>
                          </div>
                          <div class="col-md-6">
                             <?=$rec->delivery->location ?>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <p>City:</p>
                          </div>
                          <div class="col-md-6">
                             <?=$rec->city ?>
                          </div>
                        </div>
                        </div> 
                        <?php } ?>
                      </div>
                                       
                  </div>
                  <div class="col-sm-6">
                    <div class="panel-body">
                    <div class="col d-flex justify-content-center">
                        <div class="card shadow">
                        <div class="card-body">
                          <h4>Choose Your desired Payment Method: </h4> 
                          <h6 class="text-muted">Trusted payment, 100% Money Back Guarantee</h6>
                          <form action="#">
                              <!-- Input trigger order now modal -->
                            <input type="checkbox" class="ml-3" id="can" name="mpesa" value="1"><label for="mpesa" class="ml-3" > Mpesa</label><img src="<?= Yii::$app->request->baseUrl ?>/img/mpesa.png?>" class="ml-3" width="80px" alt="Mpesa">                           
                        
                            <br>
                            <input type="checkbox" class="ml-3" id="cash" name="mpesa" value="cash" onclick="analyzeColor2(this.value);"><label for="mpesa" class="ml-3"> Cash on Delivery</label>
                          </form>
                          <hr class="line">
                            
                           <div class="row invoice">
                            <div class="col">
                              <h3>Total Amount:  Ksh <?= $total?>
                              <input type="submit" name="sendmpesa" class="btn btn-success float-right  px-3 py-2 ml-3 deposit deliversy" id="sendmpesa" disabled="disabled" value="Continue to Pay">
                            </h3>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                </div>           
               </div> <!-- col.// -->
                </div>
                    <!-- <a href="#" baseUrl="<?= Yii::$app->request->baseUrl?>" id="<?=$rec->id?>" productId="<?=$listing->productId?>"userId="<?= Yii::$app->user->id?>" orderId="<?=$order->orderId?>" paymeny="" class="btn btn-primary mt-3 px-3 py-2 float-right delivery"> Continue to pay </a> -->

                    
                    <input type="submit" baseUrl="<?= Yii::$app->request->baseUrl?>" productId="<?=$listing->productId?>"userId="<?= Yii::$app->user->id?>" orderId="<?=$order->orderId?>"  class="btn btn-primary mt-3 px-3 py-2 float-right delivery" id="sendcash"x value="Complete">

                  <!-- <a href="#" baseUrl="<?= Yii::$app->request->baseUrl?>" id="<?=$rec->id?>" productId="<?=$listing->productId?>"userId="<?= Yii::$app->user->id?>" orderId="<?=$order->orderId?>"  class="btn btn-primary nextBtn mt-3 px-3 py-2 float-right delivery"> Next </a> -->
                  
                  <?php }?>
            </div>
            
            <div class="panel panel-primary setup-content" id="step-3">
                 <div class="panel-body">
                    <div class="col d-flex justify-content-center">
                        <div class="card shadow">
                        <div class="card-body">
                          <h1>Payment Method</h1> 
                          <h6 class="text-muted">Trusted payment, 100% Money Back Guarantee</h6>
                          <form action="#">
                              <!-- Input trigger order now modal -->
                            <input type="radio" id="mpesa" name="payment" value="mpesa" data-toggle="modal" data-target="#myModal"><label for="mpesa">Mpesa</label> <img src="<?= Yii::$app->request->baseUrl ?>/img/mpesa.png?>" class="thumb" alt="Mpesa">
                            
                              <!-- Modal -->
                              <div class="modal fade pesa" id="myModal" role="dialog">
                                <div class="modal-dialog">
                                
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title" style="margin-left: 60px;">M-PESA Account</h4>  <br>
                                       <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                    <div class="modal-body">
                                     <p>Confirm Phone No. then click "Proceed" to generate payment request to your phone</p>
                                     <p>Enter Your MPESA PIN on prompt pop-up on your phone to complete the payment</p>
                                     <label style="line-height: 4em;">+254712345678</label>
                                    <div class="mode ">
                                    <div class="modal-footer">
                                      <a href="<?= Url::to(['checkout/create' ])?>"><button type="button" id="mpesa" value="mpesa"  class="btn btn-primary" onclick="analyzeColor2(this.value);">Proceed</button></a>        

                                    </div>
                                  </div>
                                  </div>
                                  </div>
                                </div>
                              </div><!-- / Order Now modal-->

                            <br>
                            <input type="radio" id="card" name="payment" value="card" onclick="analyzeColor2(this.value);"> <label for="female">Card</label> <img src="<?= Yii::$app->request->baseUrl ?>/img/vima.jpeg?>" class="thumb" alt="Payment Cards">
                          </form>
                          <hr class="line">
                            
                           <div class="row invoice">
                            <div class="col">
                              <h2>Total Amount:  Ksh <?= $total?></h2>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php }?>
<?php
    Modal::begin([
        'id'=>'deposit',
        'size'=>'modal-md'
        ]);
    echo "<div id='depositContent'></div>";
    Modal::end();
  ?>
 <script>
function analyzeColor2(myColor) {
  if (myColor == "cash") {
    alert("Thankyou for buying from us, you will receive your products in few days time!");
    }
    else if(myColor == "mpesa") {
      alert("Check your phone request has successfully been sent!")
    }
  function displayModal(){
      $('myModal').modal('show')    
    }
}

var checker = document.getElementById('can');
var sendbtn = document.getElementById('sendmpesa');
checker.onchange = function(){
  if(this.checked){
 sendbtn.disabled = false;
}else {
   sendbtn.disabled = true;
}
}
var next = document.getElementById('cash');
var nextbtn = document.getElementById('sendcash');
next.onchange = function(){
  if(this.checked){
 nextbtn.disabled = false;
}else {
 nextbtn.disabled = true;
}
}
</script>


