<?php

use yii\helpers\Html;
use common\models\User;
use yii\bootstrap4\Modal;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Delivery; 

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\bootstrap4\ActiveForm */


?>
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-6"> 
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small>Add Delivery</small></p>
            </div>
        </div>
    </div>
    
   <?php $form = ActiveForm::begin(); ?>
        <div class="panel panel-primary setup-content" id="step-1">
            <div class="panel-heading">
                 <h3 class="panel-title">Add Delivery</h3>
            </div>
            <div class="panel-body">
                <div class="product-form">
               
                <?php echo $form->errorSummary($model) ?>
                <?= $form->field($model, 'location')->textInput() ?>

                <?= $form->field($model, 'fee')->textInput() ?>

                <?= $form->field($model, 'createdBy')->textInput()->hiddenInput(['value' =>Yii::$app->user->id, 'readonly'=>true])->label(false) ?>
                
                </div> 
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary nextBtn pull-right"']) ?>
            </div>
        </div>   

        
    <?php ActiveForm::end(); ?>

