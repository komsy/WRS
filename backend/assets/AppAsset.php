<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/stepper.css',
        'css/jquery.dataTables.min.css',
        'css/adminlte.min.css',
        'css/icheck-bootstrap.min.css',
        'css/tempusdominus-bootstrap-4.min.css',        
        'css/all.min.css',
    ];
    public $js = [
        'js/myscripts.js',
        'js/jquery.dataTables.min.js',
        'js/adminlte.js',
        'js/bootstrap.bundle.min.js',
        'js/jquery.min.js',
        'js/tempusdominus-bootstrap-4.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
