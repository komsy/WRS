<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Delivery;
use common\models\User;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
$user = Delivery::find()->joinWith('createdBy0')->all();

?> 
      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Delivery</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="cashier">

                <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                       
                        <div class="col-md-6">
                            <?= $form->field($model, 'location') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'fee') ?>
                        </div>
                         <div class="col-md-6">
                            <?= $form->field($model, 'createdBy')->textInput()->hiddenInput(['value' =>Yii::$app->user->id, 'readonly'=>true])->label(false) ?>
                        </div>
                    </div>
                    <div class="form-group">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <?= Html::submitButton('Submit', ['class' => 'btn btn-primary float-right']) ?>
                    </div>
                <?php ActiveForm::end(); ?>

            </div><!-- cashier -->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

<!--Main layout-->
 <div class="content-wrapper">
    <section class="content pt-4">
    <section class="mb-4">
      <div class="card">
        <div class="card-body d-sm-flex justify-content-between">

          <h4 class="mb-2 mb-sm-0 pt-1">
            <a href="<?= Url::to(['site/index'])?>" target="_blank">Home Page</a>
            <span>/</span>
            <span>Delivery Places</span>
            </h4>
             <button type="button" class="btn btn-primary float right" data-toggle="modal"  data-target="#modal-default">
             <i class="fa fa-plus" aria-hidden="true"></i> ADD Delivery </button>
          
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
                    <th>Location</th>
                    <th>Fee</th>
                    <th>Created By</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($user as $list) {?> 
                  <tr>
                    <td> <?=$list->deliveryId ?> </td>
                    <td> <?=$list->location ?> </td>
                    <td> <?=$list->fee ?> </td>
                    <td> <?=$list->createdBy0->username ?> </td>
                    
                    <td>
                     <a href="<?=Url::to(['delivery/update', 'id'=>$list->deliveryId])?>"><button type="button" class="badge badge-pill btn-primary px-3 py-2 ">Edit</button></a>

                      <a href="#" baseUrl="<?= Yii::$app->request->baseUrl?>" id="<?=$list->deliveryId?>" class="badge badge-pill btn-danger px-3 py-2 komsy"> Delete </a>
                    </td>
                  </tr>
                <br>                 
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


