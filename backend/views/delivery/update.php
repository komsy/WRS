<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = 'Update Delivery: ' . $model->location;
$this->params['breadcrumbs'][] = ['label' => 'Delivery', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->deliveryId, 'url' => ['view', 'id' => $model->deliveryId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="content-wrapper">
	<section class="content pt-4">
		<div class="delivery-update">

		    <h1><?= Html::encode($this->title) ?>
		    <a href="<?= Url::to(['delivery/records'])?>" class="badge bg-danger p-2 text-white float-right">Back</a></h1>

		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
</section>
</div>
