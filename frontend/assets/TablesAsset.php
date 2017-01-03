<?php
namespace frontend\assets;

class TablesAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/tables';

    public $css = [
        //'jquery.fancybox.css',
    ];
    public $js = [
        'init.js',
        'jquery.dataTables.min.js'
    ];

    public $depends = ['yii\web\JqueryAsset'];
}