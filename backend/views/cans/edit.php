<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Product;

/* @var $this yii\web\View */
/* @var $model backend\models\Cans */
/* @var $form yii\widgets\ActiveForm */

$can = ArrayHelper::map(Product::find()->all(), 'productId', 'productName');
?>
<div class="content-wrapper">
    <section class="content pt-4">
        <div class="cans-form">

            <?php $form = ActiveForm::begin(['id' => 'product-create'],[
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>

            <?= $form->field($model, 'productId')->dropDownList($can,['prompt'=>'Select Product Name'])->label(false) ?>

            <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'amount')->textInput() ?>

            <?= $form->field($model, 'canImage')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
</section>
</div>
