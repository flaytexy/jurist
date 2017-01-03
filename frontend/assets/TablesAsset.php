<?php
namespace frontend\assets;

class TablesAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/tables';

    public $css = [
        'css/jquery.dataTables.min.css',
    ];
    public $js = [
        'js/init.js',
        'js/jquery.dataTables.min.js'
    ];

    public $depends = ['yii\web\JqueryAsset'];
}