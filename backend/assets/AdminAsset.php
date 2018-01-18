<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/vendor.css',
        'css/app.css',
    ];
    public $js = [
        //'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js',
        //'http://code.jquery.com/jquery-2.2.4.js',
        'https://code.jquery.com/jquery-migrate-3.0.0.js',
        'https://code.jquery.com/jquery-migrate-1.4.1.min.js',
        'js/vendor.js',
        'js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
