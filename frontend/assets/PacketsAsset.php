<?php
namespace frontend\assets;

class PacketsAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/packets';
    public $css = [
        'packets.css',
    ];
    public $js = [
        'packets.js?v=2'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
