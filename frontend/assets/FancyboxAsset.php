<?php
namespace frontend\assets;

class FancyboxAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/fancybox/dist';

    public $css = [
        //'jquery.fancybox.css',s
    ];
    public $js = [
        //'jquery.fancybox.pack.js'
        'jquery.fancybox.js'
    ];

    public $depends = ['yii\web\JqueryAsset'];
}