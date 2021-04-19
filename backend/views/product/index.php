<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Product;
use common\models\User;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */

$user = Product::find()->joinWith('createdBy0')->all();
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
            <span>Products</span>
            </h4> 
            <p>
                <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success float-right']) ?>
            </p>         
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
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Discount</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Product Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($user as $use) {?> 
                  <tr>
                    <td> <?=$use->productId ?> </td>
                    <td> <?=$use->productName ?> </td>
                    <td> <?=$use->quantity ?> </td>
                    <td> <?=$use->unitPrice ?> </td>
                    <td> <?=$use->discount ?> </td>
                    <td> <?=$use->createdBy0->username ?> </td>
                    <td> <?=$use->createdAt ?> </td><td> <img src="<?= Yii::$app->request->baseUrl.'/'.$use->imagePath ?>" class="center" width="50px"  alt="Patient Image"> </td>
                    <td>
                     <a href="<?=Url::to(['product/update', 'id'=>$use->productId])?>"><button type="button" class="badge badge-pill btn-primary px-3 py-2 ">Edit</button></a>
                     
                      <a href="#" baseUrl="<?= Yii::$app->request->baseUrl?>" id="<?=$use->productId?>" class="badge badge-pill btn-danger px-3 py-2 trash"> Delete </a>
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