<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $sourcePath = '@frontend/media';
    public $css = [
        /*'css/bootstrap.css',*/
        //'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        //'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css',

        /*'css/icons.css',*/
        ///'css/font-awesome/css/font-awesome.min.css',
        ///'css/flaticon.css?v=5',
        ///'js/fancybox/jquery.fancybox.css',
        ///'css/datepicker.css',
        ///'css/select2.css',
        ///'css/perfect-scrollbar.css',
        //'css/owl.css',
        ///'css/opensans.css',
        //'css/table.css',

        //'https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css',
        //'https://fonts.googleapis.com/css?family=Cabin',

        //'css/normalize.min.css',

        //'css/bootstrap-submenu.min.css?v=2017-03-18-3',

        //'//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css',
        //'//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css',
        //'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/vader/theme.min.css',

//        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        //'css/bootstrap.css', //*last
        'css/jquery-ui.smoothness.1.12.1.css', //*last
        'css/bootstrap.4.1.3.min.css',

        'css/flaticon.css', //*last
//        //'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css', //*last
        'css/font-awesome/css/font-awesome.min.css', //*last
        'css/animate.3.2.3.css', //*last
//        //'css/prefix.min.css?v=2017-02-25-2',
        'css/prefix2.css?v=2018-01-18-v01', //*last
        'css/styles.css?v=2018-05-16-v05', //*last
//        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',


        //'https://fonts.googleapis.com/css?family=Cabin',
        //'https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css',
        //'http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css',

        //'css/font-awesome/css/font-awesome.min.css',
        //'css/frontend.css',
        //'css/responsive.css',
        //'css/color.css'
    ];
    public $js = [
        //'https://code.jquery.com/jquery-migrate-3.0.1.min.js',
        '//code.jquery.com/jquery-migrate-3.0.1.min.js',

        'js/bootstrap/bootstrap.4.1.0.min.js',
        'js/bootstrap/popper.1.14.0.min.js',

        'js/bootstrap-datepicker.js',
        'js/fancybox/jquery.fancybox.pack.js',

        'js/owl.carousel.min.js',
        //'js/select2.full.js',

        'js/scrollupbar.js',
        'js/perfect-scrollbar.js',
        'js/perfect-scrollbar.jquery.js',
        'js/jquery.scrolly.js', //
        'js/bootstrap-submenu.js',
        //'//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
        'js/slick.1.8.0.js',

        //'/uploads/newin.js?v=2017-11-13-v3',

        'js/all.js?v=2018-07-11-v01',
        'js/scripts.js?v=2018-09-02-v03',
        //'//code.jquery.com/jquery-2.2.4.min.js',
        //'//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js',
        //'//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js',
        //'js/scriptsnew.js?v=2017-12-08-v6',


        //'//widget.privy.com/assets/widget.js',

        //'js/frontend.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        //'frontend\assets\FoundationTableAsset',
        //'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\YiiAsset',
    ];

    public function init()
    {
        if (!YII_DEBUG) {
            $this->css = [
                'css/style_all.min.css?v=2018-07-10-v08'
            ];
        }

        parent::init(); // TODO: Change the autogenerated stub
    }
}
