<?php
use yii\helpers\Url;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Nav;

?>
  <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options'=>[
            'class'=>'shadow-lg navbar navbar-expand-lg navbar-light bg-light'
        ]
    ]);

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login <i class="fas fa-sign-in-alt"></i>', 'url' => ['/site/login']];
    } else {

         
        $menuItems[] = ['label' => 'Logout <i class="fas fa-sign-out-alt"></i> ('.Yii::$app->user->identity->username.')',
            'url'=>['site/logout'],
            'linkOptions'=>[
                'data-method'=>'post'
            ]
        ];
    
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto '],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>