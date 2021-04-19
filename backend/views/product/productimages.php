<?php
use yii\helpers\Html; 
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Product; 
 
/* @var $this yii\web\View */ 
/* @var $model backend\models\ProductImages */ 
/* @var $form ActiveForm */ 

$product = ArrayHelper::map(product::find()->all(), 'productId', 'productName'); //map all data in producttable and select product id and product name
?>
<div class="productimages"> 
 
   <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'] ]); ?> 
 
       <?= $form->field($model, 'imagePath') ?> 
       <?= $form->field($model, 'productId')->textInput()->dropDownList($product, ['placeholder'=>'Select Product']) ?> 
    
       <div class="form-group"> 
           <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?> 
       </div> 
   <?php ActiveForm::end(); ?> 
 
</div><!-- productimages --> 