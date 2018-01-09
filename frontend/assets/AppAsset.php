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
        ///'css/font-awesome/css/font-awesome.min.css',
        ///'css/flaticon.css?v=5',
        ///'js/fancybox/jquery.fancybox.css',
        ///'css/datepicker.css',
        ///'css/select2.css',
        ///'css/perfect-scrollbar.css',
        //'css/owl.css',
        ///'css/opensans.css',
        //'css/table.css',
        'https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css',

        'https://fonts.googleapis.com/css?family=Cabin',
        'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',

        'css/revolution.css?v=2017-02-25-2',
        'css/prefix.min.css?v=2017-02-25-2',
        'css/bootstrap-submenu.min.css?v=2017-03-18-3',

        //'//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css',
        //'//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css',
        'css/styles.css?v=2017-12-12-v13',

//<link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">
//<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
//<link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css'>
//<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
//<link rel="stylesheet" href="/uploads/style.css?v=2017-11-26-v1">
        //'https://fonts.googleapis.com/css?family=Cabin',
        //'https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css',
        //'http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css',
        //'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
        //'css/style2.css?v=2017-11-26-v1',

        //'css/frontend.css',
        //'css/responsive.css',
        //'css/color.css'
    ];
    public $js = [
        //'https://code.jquery.com/jquery-migrate-3.0.1.min.js',
        'js/bootstrap-datepicker.js',
        'js/fancybox/jquery.fancybox.pack.js',

        'js/owl.carousel.min.js',
        'js/select2.full.js',

        'js/scrollupbar.js',
        'js/perfect-scrollbar.js',
        'js/perfect-scrollbar.jquery.js',
        'js/jquery.scrolly.js', //
        'js/bootstrap-submenu.js',

        '/uploads/slick.js?v=2017-12-10-v8',
        //'https://maps.googleapis.com/maps/api/js?key=AIzaSyAHpsQLvCsVj-lsinvgPKSns0YhnRW8gtE&callback=initMap',
        //'/uploads/newin.js?v=2017-11-13-v3',

        'js/all.js?v=2017-03-21-1',
        'js/scripts.js?v=2017-12-08-v8',
        //'//code.jquery.com/jquery-2.2.4.min.js',
        //'//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js',
        //'//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js',
        //'js/scriptsnew.js?v=2017-12-08-v6',



        '//widget.privy.com/assets/widget.js'

        //'js/frontend.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        //'frontend\assets\FoundationTableAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\YiiAsset',
    ];
}
