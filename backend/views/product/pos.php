<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Modal;
use common\models\User;
use backend\models\Pos;

/* @var $this yii\web\View */
$list = Pos::find()->where(['status'=>'0'])->all();
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
            <span>Point of Sale</span>
            </h4>  
             <a href="<?= Url::to(['product/deleted'])?>"><button type="button" class="btn btn-danger float right">
             Deleted Records </button>  </a>    
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