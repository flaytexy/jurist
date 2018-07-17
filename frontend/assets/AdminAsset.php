<?php
namespace frontend\assets;

class AdminAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/media';
    public $css = [
        //'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        //'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css',
        'css/admin.css',
        'css/vendor.css',
        'css/glyphicons.css',
        'css/style_all.min.css',
    ];
    public $js = [
        'js/vendor.js?v=1',
        //'js/Sortable.min.js',
        //'js/jquery.binding.js',
        //'js/bootstrap-toolkit-1.5.0.min.js',
        'js/admin.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'frontend\assets\SwitcherAsset',
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
}
