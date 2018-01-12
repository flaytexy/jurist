<?php
namespace frontend\assets;

class BanksAsset extends \yii\web\AssetBundle
{
    //public $sourcePath = '@frontend/assets/banks';

    public $sourcePath = '@frontend/media';

    public $css = [
        //'css/frontend.css',
    ];
    public $js = [
        'js/banks.js',
    ];
    public $depends = [
        'frontend\assets\TablesAsset',
        'akavov\countries\assets\CountriesAsset',
        'frontend\assets\SwitcherAsset'
    ];
}
