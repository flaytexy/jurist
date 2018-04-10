<?php
namespace frontend\assets;

class BanksAsset extends \yii\web\AssetBundle
{
    //public $sourcePath = '@frontend/assets/banks';

    public $sourcePath = '@frontend/media';

    public $css = [
        //'css/frontend.css',
        'css/banks.css',
    ];
    public $js = [
        'js/banks.js',
        //'//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js'
    ];
    public $depends = [
        'frontend\assets\AppAsset',
        'akavov\countries\assets\CountriesAsset',
        /*'frontend\assets\SwitcherAsset',*/
        'frontend\assets\TablesAsset',
    ];
}
