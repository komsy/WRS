<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Cans */
/* @var $form ActiveForm */
?>
<div class="cans">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'productId') ?>
        <?= $form->field($model, 'type') ?>
        <?= $form->field($model, 'amount') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- cans -->
