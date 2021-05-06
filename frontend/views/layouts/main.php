<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-dark bg-dark sticky-top',
        ],
    ]);
    $menuItems = [];
     if (Yii::$app->user->isGuest) {

        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        if(\Yii::$app->user->can('User')) {
        $menuItems [] = ['label' => 'Home', 'url' => ['/site/index'] ];
        $menuItems [] = ['label' => 'Products', 'url' => ['/product/index'] ];
        $menuItems [] = ['label' => 'My Orders', 'url' => ['/product/orders'] ];
        $menuItems [] = ['label' => 'Order History', 'url' => ['/product/history'] ];
        
        $menuItems [] = ['label' => 'Contact', 'url' => ['/site/contact'] ];
        $menuItems[] = ['label' => 'Logout ('.Yii::$app->user->identity->username.')',
            'url'=>['site/logout'],
            'linkOptions'=>[
                'data-method'=>'post'
            ]
        ];  
       } 
       elseif(\Yii::$app->user->can('Cashier')) {
        $menuItems [] = [
            'label' => 'Orders',
            'items' => [
                 ['label' => 'Manage Orders', 'url' => ['/product/orderitems']],
                 '<div class="dropdown-divider"></div>',
                 ['label' => 'Order Details', 'url' => ['/product/details']],
            ],
      ];
        $menuItems [] = ['label' => 'POS', 'url' => ['/cashier/index'] ];
        $menuItems [] = ['label' => 'Contact', 'url' => ['/site/contact'] ];
        $menuItems[] = ['label' => 'Logout ('.Yii::$app->user->identity->username.')',
            'url'=>['site/logout'],
            'linkOptions'=>[
                'data-method'=>'post'
            ]
        ];
        }
    }
  
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        </div>
        <?= $content ?>
    
</div>

<footer class="footer">
    <div class="container">
        <p class="text-center">&copy; <?= Html::encode('Imperial') ?> <?= date('Y') ?></p>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
