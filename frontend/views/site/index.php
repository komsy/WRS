<?php

use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Water Refilling System';
?>
 <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel" >
  <div class="carousel-inner">
    <div class="carousel-item active" data-interval="10000">
      <img src="<?= Yii::$app->request->baseUrl ?>/img/slide5.jpg" class="d-block w-100" alt="..." height="800px">
      <div class="carousel-caption">
          <h3>Nairobi</h3>
          <p>LA is always so much fun!</p>
        </div>
    </div>
    <div class="carousel-item" data-interval="2000">
      <img src="<?= Yii::$app->request->baseUrl ?>/img/slide2.jpg" class="d-block w-100" alt="..." height="800px">
      <div class="carousel-caption">
          <h3>Nairobi</h3>
          <p>LA is always so much fun!</p>
        </div>
    </div>
    <div class="carousel-item">
      <img src="<?= Yii::$app->request->baseUrl ?>/img/slide4.jpg" class="d-block w-100" alt="..." height="800px">
      <div class="carousel-caption">
          <h3>Nairobi</h3>
          <p>LA is always so much fun!</p>
        </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>