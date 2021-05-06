<?php 

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use frontend\models\Orders;

$order = Orders::find()->select('orderId')->where(['userId'=>Yii::$app->user->id])->where(['orderStatus'=>'New'])->one();

?>
<div class="modelsit">
  <div class="row">
  <div class="card" style="width:100%;">
    <div class="card-body">
      <h1 class="card-title text-center" style="font-weight: bold;">Imperial Water Refilling </h1>
      <h4>Mpesa Payment Method</h4> 
      <h6 class="text-muted">Trusted payment, 100% Money Back Guarantee</h6>
      <form action="#">
          <!-- Input trigger order now modal -->
       <img src="<?= Yii::$app->request->baseUrl ?>/img/mpesa.png?>" class="modelsit" >
        <br>
      </form>
      <hr class="line">
         <p class="text-center" style="font-weight: bold;">Enter Your MPESA PIN on prompt pop-up on your phone to complete the payment</p>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'MerchantRequestId')->hiddenInput(['value' =>Yii::$app->user->id, 'readonly'=>true])->label(false) ?>
        <?= $form->field($model, 'orderId')->hiddenInput(['value' =>$order->orderId, 'readonly'=>true])->label(false) ?>
        <?= $form->field($model, 'createdBy')->hiddenInput(['value' =>Yii::$app->user->id, 'readonly'=>true])->label(false) ?>
        <?= $form->field($model, 'transAmount') ?>
        <?= $form->field($model, 'mpesaNumber') ?>
        <?= $form->field($model, 'details') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
  </div>
  </div>
</div><!-- modelsit -->