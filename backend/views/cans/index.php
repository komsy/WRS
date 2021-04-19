<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Product;
use backend\models\Cans;
use common\models\User;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */

$user = Cans::find()->all();
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
            <span>Cans</span>
            </h4> 
            <p>
                <?= Html::a('Create Cans', ['create'], ['class' => 'btn btn-success float-right']) ?>
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
                    <th>Can ID</th>
                    <th>Product Name</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Can Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($user as $use) {?> 
                  <tr>
                    <td> <?=$use->canId ?> </td>
                    <td> <?=$use->product->productName ?> </td>
                    <td> <?=$use->type ?> </td>
                    <td> <?=$use->amount ?> </td>
                    <td> <img src="<?= Yii::$app->request->baseUrl.'/'.$use->canImage ?>" class="center" width="50px"  alt="Patient Image"> </td>
                    <td>
                     <a href="<?=Url::to(['cans/update', 'id'=>$use->canId])?>"><button type="button" class="badge badge-pill btn-primary px-3 py-2 ">Edit</button></a>
                     
                      <a href="#" baseUrl="<?= Yii::$app->request->baseUrl?>" id="<?=$use->canId?>" class="badge badge-pill btn-danger px-3 py-2 trash"> Delete </a>
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
