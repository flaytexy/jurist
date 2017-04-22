<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;
use yii\web\AssetBundle;

/**
 * This asset bundle provides the [jQuery](http://jquery.com/) JavaScript library.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FoundationTableAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/foundation';

    public $css = [
        'css/table.css',
    ];
    public $js = [
        //'js/init.js'
    ];

    //public $depends = ['yii\web\JqueryAsset'];
}
