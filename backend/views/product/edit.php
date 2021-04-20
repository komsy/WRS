<?php

use yii\helpers\Html;
use common\models\User;
use yii\bootstrap4\Modal;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Product; 
use backend\models\ProductImages;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\bootstrap4\ActiveForm */

$product = ArrayHelper::map(product::find()->all(), 'productId', 'productName'); //map all data in producttable and select product id and product name
?>
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-6"> 
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small>Add Product</small></p>
            </div>
        </div>
    </div>
    
   <?php $form = ActiveForm::begin(['id' => 'product-create'],[
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
        <div class="panel panel-primary setup-content" id="step-1">
            <div class="panel-heading">
                 <h3 class="panel-title">Add Product</h3>
            </div>
            <div class="panel-body">
                <div class="product-form">
               
                <?php echo $form->errorSummary($model) ?>
                <?= $form->field($model, 'productName')->textInput() ?>

                <?= $form->field($model, 'quantity')->textInput() ?>

                <?= $form->field($model, 'unitPrice')->textInput() ?>

                <?= $form->field($model, 'discount')->textInput() ?>

                <?= $form->field($model, 'imagePath')->textInput() ?>
                 <img src="<?= Yii::$app->request->baseUrl.'/'.$model->imagePath ?>" class="center" width="50px"  alt="Product Image"> 
                <?= $form->field($model, 'createdBy')->textInput()->hiddenInput(['value' =>Yii::$app->user->id, 'readonly'=>true])->label(false) ?>
                
                </div> 
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary nextBtn pull-right"']) ?>
            </div>
        </div>   

        
    <?php ActiveForm::end(); ?>

