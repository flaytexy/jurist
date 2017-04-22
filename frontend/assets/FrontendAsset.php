<?php
namespace frontend\assets;

class FrontendAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/media';
    public $css = [
        'css/frontend.css',
    ];
    public $js = [
        'js/frontend.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'frontend\assets\SwitcherAsset'
    ];
}
