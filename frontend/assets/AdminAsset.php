<?php
namespace frontend\assets;

class AdminAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/media';
    public $css = [
        //'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        //'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css',
        //'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css',
        //'css/bootstrap.4.1.3.min.css',
        'css/admin.css',
        //'css/vendor.css?v=1562456',
        'css/glyphicons.css',
        'css/style_all.min.css', //
//       'css/jquery-ui.smoothness.1.12.1.css',
        'css/bootstrap.4.1.3.min.css'
//        // style_all.min.css:
        //'frontend/media/css/jquery-ui.smoothness.1.12.1.css',
//        //'frontend/media/css/bootstrap.4.1.3.min.css',
//        //'frontend/media/css/flaticon.css',
//        //'frontend/media/css/font-awesome/css/font-awesome.min.css',
//        //'frontend/media/css/animate.3.2.3.css',
//        //'frontend/media/css/prefix2.css',
//        //'frontend/media/css/styles.css'

    ];
    public $js = [

        //'https://code.jquery.com/jquery-3.3.1.slim.min.js',
        'https://code.jquery.com/ui/1.12.0-rc.2/jquery-ui.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js',
        'js/vendor.js?v=2',
        //'js/Sortable.min.js',
        //'js/jquery.binding.js',
        //'js/bootstrap-toolkit-1.5.0.min.js',
        'js/admin.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
//        'frontend\assets\JqueryUIAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
        'frontend\assets\SwitcherAsset',
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
}
