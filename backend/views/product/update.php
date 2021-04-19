<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = 'Update Product: ' . $model->productName;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->productId, 'url' => ['view', 'id' => $model->productId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="content-wrapper">
	<section class="content pt-4">
		<div class="product-update">

		    <h1><?= Html::encode($this->title) ?>
		    <a href="<?= Url::to(['product/index'])?>" class="badge bg-danger p-2 text-white float-right">Back</a></h1>

		    <?= $this->render('edit', [
		        'model' => $model,
		        'can' => $can,
		    ]) ?>
		</div>
</section>
</div>
