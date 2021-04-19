<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customers */
/* @var $form ActiveForm */
?>
<div class="container">
    <div class="row text-center" >
        <div class="col" > 
            <button class="btn btn-dark view" style="width: 100%; background-color: green;"> <i class="fas fa-plus-circle"></i> Create Profile </button>
        </div>
    </div>
<div class="customers">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'userId')->hiddenInput(['value' =>Yii::$app->user->id, 'readonly'=>true])->label(false) ?>
        <?= $form->field($model, 'fullName') ?>
        <?= $form->field($model, 'address1') ?>
        <?= $form->field($model, 'address2') ?>
        <?= $form->field($model, 'contactNumber') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- customers -->
</div>