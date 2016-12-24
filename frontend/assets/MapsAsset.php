<?php
namespace frontend\assets;

class MapsAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/maps';
    public $css = [
        'css/jquery-jvectormap-2.0.3.css',
    ];
    public $js = [
        'js/css3-mediaqueries.js',
        'js/modernizr.js',
        'js/jquery-jvectormap-2.0.3.min.js',
        'js/tabs.js',
        'js/jquery-jvectormap-world-mill.js',
        'js/mapInit.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
