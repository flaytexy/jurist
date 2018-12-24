<?php
namespace frontend\assets;

class FrontendAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/media';
    public $css = [
        'jquery.switchButton.css'
    ];
    public $js = [
        'js/frontend.js',
        'js/jquery.switchButton.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'frontend\assets\SwitcherAsset'
    ];
}
