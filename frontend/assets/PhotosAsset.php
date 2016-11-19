<?php
namespace frontend\assets;

class PhotosAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/assets/photos';
    public $css = [
        'photos.css',
    ];
    public $js = [
        'photos.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
