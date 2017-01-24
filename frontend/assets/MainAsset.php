<?php
namespace frontend\assets;

class MainAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/main';
    public $css = [
        //'css/main.css',
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
        'js/main.js?v=2017-01-24'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
