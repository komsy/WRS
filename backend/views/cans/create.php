<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cans */

$this->title = 'Create Cans';
$this->params['breadcrumbs'][] = ['label' => 'Cans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-wrapper">
	<section class="content pt-4">
		<div class="cans-create">

		    <h1><?= Html::encode($this->title) ?></h1>

		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
	</section>
</div>
