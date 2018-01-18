<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');


return [
    'name' => 'KUZNIETSOV',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'log',
        'backend\modules\admin\Bootstrap',
        'backend\modules\main\Bootstrap',
        'backend\modules\user\Bootstrap',
        'backend\modules\menu\Bootstrap',
        'backend\modules\page\Bootstrap',
        'backend\modules\news\Bootstrap',
        'backend\modules\album\Bootstrap',
        'backend\modules\video\Bootstrap',
        'backend\modules\press\Bootstrap',
        'backend\modules\attachment\Bootstrap',
        'backend\modules\park\Bootstrap',
        'backend\modules\currency\Bootstrap',
        'backend\modules\seo\Bootstrap',
//        'backend\modules\seo\components\Seo',
    ],
    'components' => [
//        'session' => [
//            'class' => 'yii\web\Session'
//        ],
        'db' => $db,
        'urlManager' => [
            'class' => 'yii\web\UrlManager', //@todo lang url manager
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'backend\modules\seo\components\SeoUrlRule',
                ],
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'prefix' => 'admin',
                    'routePrefix' => 'admin',
                    'rules' => [
                        'login' => 'user/user/login',
                        'settinger' => 'default/settinger',

                        '' => 'default/index',
                        '<_m:[\w\-]+>' => '<_m>/default/index',
                        '<_m:[\w\-]+>/<id:\d+>' => '<_m>/default/view',
                        '<_m:[\w\-]+>/<id:\d+>/<_a:[\w-]+>' => '<_m>/default/<_a>',
                        '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
                        '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
                        '<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',
                    ],
//                    //Eq
//                    [
//                        'admin/login' => 'admin/user/login',
//                        'admin/logout' => 'admin/user/logout',
//                        'admin/dashboard' => 'admin/default/dashboard',
//                    ]
                ],

                '' => 'main/default/index',
                'contacts' => 'main/contact/index',
                //'about' => 'main/default/about',
                'photo' => 'album/default/index',
                'video' => 'video/default/index',
                //'contact' => 'main/contact/index',
                //'contact' => 'main/contact/index',
                'contact' => 'main/contact/index',
                'flush-cache' => 'main/cache/flush',
                '<_a:error>' => 'main/default/<_a>',

                //'<_a:(login|logout|signup|email-confirm|password-reset-request|password-reset)>' => 'admin/user/user/<_a>',

                '<_m:[\w\-]+>' => '<_m>/default/index',
                '<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w-]+>' => '<_m>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
            ],
        ],
        'settings' => [
            'class' => 'backend\modules\settings\components\Settings'
        ],
        'authManager' => [
            'class' => 'elisdn\hybrid\AuthManager',
            'modelClass' => 'backend\components\UserIdentity',
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'cache' => [
//            'class' => 'yii\caching\FileCache',
            'class' => 'yii\caching\DummyCache',
        ],
        'log' => [
            'class' => 'yii\log\Dispatcher',
        ],
        'assetManager' => [
            'assetMap' => [
                'jquery.js' => '//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js',
            ],
        ],
    ],
    'params' => $params,
];