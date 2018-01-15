<?php
namespace frontend\assets;

class MainAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/main';
    public $css = [
        'css/revolution.css?v=2017-02-25-2',
        'css/main.css',
        //'css/perfect-scrollbar.css'
    ];
    public $js = [
        'js/revolution/jquery.themepunch.tools.min.js',
        'js/revolution/jquery.themepunch.revolution.min.js',
        'js/revolution/revolution.extension.actions.min.js',
        'js/revolution/revolution.extension.carousel.min.js',
        'js/revolution/revolution.extension.kenburn.min.js',
        'js/revolution/revolution.extension.layeranimation.min.js',
        'js/revolution/revolution.extension.migration.min.js',
        'js/revolution/revolution.extension.navigation.min.js',
        'js/revolution/revolution.extension.parallax.min.js',
        'js/revolution/revolution.extension.slideanims.min.js',
        'js/revolution/revolution.extension.video.min.js',
        'js/revolution/revolution.initialize.js?v=2017-01-24',
        'js/main.js?v=2018-01-11'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        /*'yii\bootstrap\BootstrapAsset',*/
        //'yii\bootstrap\BootstrapPluginAsset', // <- using this instead
        'frontend\assets\AppAsset',
    ];
}
