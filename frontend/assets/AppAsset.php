<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $sourcePath = '@frontend/media';
    public $css = [
        /*'css/bootstrap.css',*/
        /*'css/icons.css',*/
        'css/font-awesome/css/font-awesome.min.css',
        'css/flaticon.css?v=5',
        'js/fancybox/jquery.fancybox.css',
        'css/datepicker.css',
        'css/select2.css',
        'css/perfect-scrollbar.css',
        'css/owl.css',
        'css/styles.css?v=9',
        //'css/responsive.css',
        //'css/color.css'
    ];
    public $js = [
        'js/bootstrap-datepicker.js',
        'js/fancybox/jquery.fancybox.pack.js',
        'js/owl.carousel.min.js',
        'js/select2.full.js',
        'js/scrollupbar.js',
        'js/perfect-scrollbar.js',
        'js/perfect-scrollbar.jquery.js',
        'js/jquery.scrolly.js',
        'js/all.js',


        //'https://maps.googleapis.com/maps/api/js?key=AIzaSyAHpsQLvCsVj-lsinvgPKSns0YhnRW8gtE&callback=initMap',
        'js/scripts.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\YiiAsset',
    ];
}
