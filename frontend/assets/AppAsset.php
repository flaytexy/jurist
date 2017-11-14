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
        'css/revolution.css?v=2017-02-25-2',
        'css/prefix.css?v=2017-02-25-2',
        'css/bootstrap-submenu.min.css?v=2017-03-18-3',
        'css/styles.css?v=2017-03-22-6',

        //'css/frontend.css',
        //'css/responsive.css',
        //'css/color.css'
    ];
    public $js = [
        'js/bootstrap-datepicker.js',
        'js/fancybox/jquery.fancybox.pack.js',

        '/uploads/slick.js?v=2017-11-13-v2',
        '/uploads/newin.js?v=2017-11-13-v2',

        'js/owl.carousel.min.js',
        'js/select2.full.js',

        'js/scrollupbar.js',
        'js/perfect-scrollbar.js',
        'js/perfect-scrollbar.jquery.js',
        'js/jquery.scrolly.js', //
        'js/bootstrap-submenu.js',
        'js/all.js?v=2017-03-21-1',
        //'https://maps.googleapis.com/maps/api/js?key=AIzaSyAHpsQLvCsVj-lsinvgPKSns0YhnRW8gtE&callback=initMap',
        'js/scripts.js?v=2017-11-14-v2',
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
