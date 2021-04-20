<?php
use yii\helpers\Html; 
use yii\widgets\ActiveForm; 
 
/* @var $this yii\web\View */ 
/* @var $model frontend\models\Pos */ 
/* @var $form ActiveForm */ 
?>
<div class="pos"> 
 
   <?php $form = ActiveForm::begin(); ?> 
 
       <?= $form->field($model, 'productName') ?> 
       <?= $form->field($model, 'quantity') ?> 
       <?= $form->field($model, 'price') ?> 
       <?= $form->field($model, 'discountPercentage') ?> 
       <?= $form->field($model, 'createdBy') ?> 
       <?= $form->field($model, 'createdAt') ?> 
    
       <div class="form-group"> 
           <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?> 
       </div> 
   <?php ActiveForm::end(); ?> 
 
</div><!-- pos --> 