<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

    'bootstrap' => [
        //'log',
          'frontend\modules\novanews\Bootstrap',
//        'app\modules\main\Bootstrap',
//        'app\modules\user\Bootstrap',
//        'app\modules\menu\Bootstrap',
//        'app\modules\page\Bootstrap',
//        'app\modules\news\Bootstrap',
//        'app\modules\album\Bootstrap',
//        'app\modules\video\Bootstrap',
//        'app\modules\press\Bootstrap',
//        'app\modules\attachment\Bootstrap',
//        'app\modules\park\Bootstrap',
//        'app\modules\currency\Bootstrap',
//        'app\modules\seo\Bootstrap',
//        'app\modules\seo\components\Seo',
    ],

    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
