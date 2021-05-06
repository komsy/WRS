<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\StringHelper;
use frontend\models\Cans;
use frontend\models\Product;

/* @var $this yii\web\View */

$this->title = 'Product';/*
$listings = ProductImages::find()->joinWith('product')->all();*/
$products = Product::find()->joinWith('cans')->all();
//var_dump($products); exit();
?>
<div class="row ml-4 ">
		
	<?php foreach ($products as $product) {?>
		<div class="col-md-4" >
		<div class="card mt-4 mb-4" > 
		<div class="row " >
		<aside class="col-sm-5 border-right">
			<article class="gallery-wrap"> 
			<div class="img-big-wrap">
			  <div> <a href="#"><img src="<?=yii::$app->request->baseUrl.'/backend/'.$product->imagePath?>" ></a></div>
			</div> <!-- slider-product.// -->
			<div class="img-small-wrap">
			  <div class="item-gallery"> <img src="<?=yii::$app->request->baseUrl.'/backend/'.$product->cans[0]->canImage?>"> </div>
			</div> <!-- slider-nav.// -->
			</article> <!-- gallery-wrap .end// -->
		</aside>
		<aside class="col-sm-7">
			<article class="card-body p-1">
				<h3 class="title mb-3"><?=$product->productName  ?></h3>

			<p class="price-detail-wrap"> 
				<span class="price h3 text-warning"> 
					<span class="currency">KES </span><span class="num"><?=$product->unitPrice-$product->discount  ?></span>
				</span> 
			</p> <!-- price-detail-wrap .// -->

			<dl class="item-property">
			  <dt>Description</dt>
			  <dd><p>Description Here</p></dd>
			</dl>
			<dl class="param param-feature">
			  <dt>Can#</dt>
			  <dd>Each can at <?=$product->cans[0]->amount  ?></dd>
			</dl>  <!-- item-property-hor .// -->

			<hr>
				<div class="row">
					<div class="col-sm-5">
						<dl class="param param-inline">
						  <dt>Quantity: </dt>
						  <dd>
						  	<div class="form-group">
								<input type="number" id="quantity_<?= $product->productId?>" name="name" placeholder="Number" class="form-control" style="width:100px;" autocomplete="off">
							</div>
						  </dd>
						</dl>  <!-- item-property .// -->
					</div> <!-- col.// -->
					<div class="col-sm-7">
						<dl class="param param-inline">
							<dt>With Can: </dt>
							<dd>
							 <label class="form-check form-check-inline">
								  <input class="form-check-input" type="checkbox"  name="check[0]" id="can_<?= $product->productId?>" value="1">
								  <span class="form-check-label">WC</span>
								</label>
							</dd>
						</dl>  <!-- item-property .// -->
					</div> <!-- col.// -->
				</div> <!-- row.// -->
				<hr>
				<div class="form-group">
				<a href="#" baseUrl="<?= Yii::$app->request->baseUrl?>" productId="<?= $product->productId?>" userId="<?= Yii::$app->user->id?>" tot="<?=$product->unitPrice-$product->discount ?>" class="btn btn-lg btn-outline-primary text-uppercase order"> <i class="fas fa-shopping-cart"></i> Order Now</a>
			</article> <!-- card-body.// -->
		</aside> <!-- col.// -->
	</div>
	</div> <!-- row.// -->
</div>
	<br>	<?php }?>

</div> <!-- card.// -->

