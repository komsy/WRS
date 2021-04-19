<?php
use yii\bootstrap4\Nav;

?>
<aside class="shadow-sm">
	<?php
    echo Nav::widget([
        'options' => [
            'class' => 'shadow-lg d-flex flex-column nav-pills'
        ],

        'encodeLabels'=>false,

        'items' => [
            [
                'label'=>'<i class="fas fa-tachometer-alt"></i> Dashboard',
                'url'=>['/site/feedback']
            ],
            [
                'label'=>'<i class="fas fa-plus-circle"></i>Customers',
                'url'=>['/site/index']
            ],
            [
                'label'=>'<i class="fas fa-user-injured"></i> Forms',
                'url'=>['/site/viewpatient']
            ],
            [
                'label'=>'<i class="fas fa-book-medical"></i> Delivery Record',
                'url'=>['/site/viewappointment']
            ],
            [
                'label'=>'<i class="fas fa-book-medical"></i> Delivery Details',
                'url'=>['/site/viewappointment']
            ],
            [
                'label'=>'<i class="fas fa-book-medical"></i> Point of Sale',
                'url'=>['/site/viewappointment']
            ],
            [
                'label'=>'<i class="fas fa-briefcase-medical"></i> User Management',
                'url'=>['/site/users']
            ]            
        ]
    ]);
    
    ?>
</aside>
    