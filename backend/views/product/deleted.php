<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Modal;
use common\models\User;
use frontend\models\Product;
use frontend\models\Pos;

/* @var $this yii\web\View */
$use = ArrayHelper::map(Product::find()->all(), 'productId', 'productName');
$list = Pos::find()->where(['status'=>'1'])->all();
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
            <span>Deleted POS</span>
            </h4>  <a href="<?= Url::to(['product/pos'])?>" class="badge bg-danger p-2 text-white float-right">Back</a>   
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
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                    <th >Price</th>
                    <th>Total Amount</th>
                    <th>Created At</th>
                    <th >Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($list as $use) {?> 
                  <tr>
                    <td> <?=$use->posId ?> </td>
                    <td> <?=$use->productName ?> </td>
                    <td> <?=$use->quantity ?> </td>
                    <td> <?=$use->discountPercentage ?> </td>
                    <td> <?=$use->price ?> </td>
                    <td> <?=$use->totalAmount ?> </td>
                    <td> <?=$use->createdAt ?> </td>
                    
                    <td>
                    <a href="#" baseUrl="<?= Yii::$app->request->baseUrl?>" id="<?=$use->posId?>" class="badge badge-pill btn-danger px-3 py-2 deletd"> Delete </a>
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