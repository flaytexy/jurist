<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

//<link href="/css/main.css" rel="stylesheet">
//    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
//    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
//    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
//    <link href="/css/hamburgers.min.css" rel="stylesheet">
//    <link href="/css/jquery.custom-scroll.css" rel="stylesheet">

//<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
//    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
//    <script src="/js/svg.min.js"></script>
//    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
//    <script src="/js/wow.min.js"></script>
//    <script src="/js/main.js"></script>
//    <script src="/js/audio.js"></script>

//    <script src="/js/owl.carousel.min.js"></script>

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/main.css',

        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        'https://fonts.googleapis.com/css?family=Oswald',
        //'//code.jquery.com/ui/2.12.1/themes/base/jquery-ui.css',
        'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&subset=cyrillic',

        '/css/animate.css',

        '/css/hamburgers.min.css',
        '/css/jquery.custom-scroll.css',

        'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css'
    ];
    public $js = [
        'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js',
        //'https://code.jquery.com/jquery-migrate-3.0.0.js',
        //'https://code.jquery.com/jquery-migrate-1.4.1.min.js',
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js',
        'js/svg.min.js',
        'https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.min.js',
        'https://unpkg.com/masonry-layout@4.2.0/dist/masonry.pkgd.min.js',
        'js/wow.min.js',
        '/js/owl.carousel.min.js',
        'js/jquery.sticky.js',
        //'js/jquery-ui.js',
        //'js/jquery.ui.touch-punch.min.js',
        //'js/owl.carousel.min.js',
        //'js/jquery.mCustomScrollbar.concat.min.js',
        'js/main.js',
        'js/audio.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
