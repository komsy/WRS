<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\AuthAssignment;
use backend\models\AuthItem;
use backend\models\User;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
$use = ArrayHelper::map(User::find()->all(), 'id', 'username');
$item = ArrayHelper::map(AuthItem::find()->all(), 'name', 'description');
$user = User::find()->joinWith('authAssignments')->all();

?> 
      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add AuthAssignment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="cashier">

                <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'user_id')->dropDownList($use,['prompt'=>'Select New User']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'item_name')->dropDownList($item,['prompt'=>'Select Role']) ?>
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
            <span>Registered Users</span>
            </h4>  
             <button type="button" class="btn btn-primary float right" data-toggle="modal"  data-target="#modal-default">
             <i class="fa fa-plus" aria-hidden="true"></i> ADD Auth Assignment </button>        
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
                    <th>Email</th>
                    <th >Auth Assignment</th>
                    <th class="text-center">isBan/unBan</th>
                    <th class="text-center">Account Status</th>
                    <th >Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($user as $use) {?> 
                  <tr>
                    <td> <?=$use->id ?> </td>
                    <td> <?=$use->username ?> </td>
                    <td> <?=$use->email ?> </td>
                    <td> <?=$use->authAssignments[0]->item_name ?> </td>
                    <td class="text-center"> 
                      <?php if($use->isBan == '0') 
                        echo '<label class="py-2 px-3 badge btn-primary">Not Banned</label>';                      
                        elseif($use->isBan == '1')
                        echo '<label class="py-2 px-3 badge btn-danger">Banned</label>'; 
                        ?>
                    </td>
                    <td class="text-center"> 
                      <?php if($use->status == '10') 
                        echo '<label class="py-2 px-3 badge btn-primary">Activated</label>';                      
                        elseif($use->status == '9')
                        echo '<label class="py-2 px-3 badge btn-danger">Not Activated</label>'; 
                        ?>
                    </td>

                    <td>
                     <a href="<?=Url::to(['user/update', 'id'=>$use->id])?>"><button type="button" class="badge badge-pill btn-primary px-3 py-2 ">Edit</button></a>
                     
                      <a href="#" baseUrl="<?= Yii::$app->request->baseUrl?>" id="<?=$use->id?>" class="badge badge-pill btn-danger px-3 py-2 del"> Delete </a>
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