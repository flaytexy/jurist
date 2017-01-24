<?php
namespace frontend\assets;

class MainAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/main';
    public $css = [
        //'css/main.css',
    ];
    public $js = [
        'js/main.js?v=2017-01-'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
