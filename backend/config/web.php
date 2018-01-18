<?php

$config = [
    'id' => 'app',
    'language' => 'en-US', //ru-RU .. en-En
    'sourceLanguage' => 'en-US', //ru-RU
    'modules' => [
        'admin' => [
            'class' => 'backend\modules\admin\Module',
            'layout' => '@backend/views/layouts/admin',
            'modules' => [
                'settings' => [
                    'class' => 'backend\modules\settings\Module',
                    'sourceLanguage' => 'en'
                ],
                'user' => [
                    'class' => 'backend\modules\user\Module',
                    'controllerNamespace' => 'backend\modules\user\controllers\backend',
                    'viewPath' => '@backend/modules/user/views/backend',
                ],
                'menu' => [
                    'class' => 'backend\modules\menu\Module',
                    'controllerNamespace' => 'backend\modules\menu\controllers\backend',
                    'viewPath' => '@backend/modules/menu/views/backend',
                ],
                'page' => [
                    'class' => 'backend\modules\page\Module',
                    'controllerNamespace' => 'backend\modules\page\controllers\backend',
                    'viewPath' => '@backend/modules/page/views/backend',
                ],
                'news' => [
                    'class' => 'backend\modules\news\Module',
                    'controllerNamespace' => 'backend\modules\news\controllers\backend',
                    'viewPath' => '@backend/modules/news/views/backend',
                ],
                'album' => [
                    'class' => 'backend\modules\album\Module',
                    'controllerNamespace' => 'backend\modules\album\controllers\backend',
                    'viewPath' => '@backend/modules/album/views/backend',
                ],
                'video' => [
                    'class' => 'backend\modules\video\Module',
                    'controllerNamespace' => 'backend\modules\video\controllers\backend',
                    'viewPath' => '@backend/modules/video/views/backend',
                ],
                'press' => [
                    'class' => 'backend\modules\press\Module',
                    'controllerNamespace' => 'backend\modules\press\controllers\backend',
                    'viewPath' => '@backend/modules/press/views/backend',
                ],
                'attachment' => [
                    'class' => 'backend\modules\attachment\Module',
                    'controllerNamespace' => 'backend\modules\attachment\controllers\backend',
                    'viewPath' => '@backend/modules/attachment/views/backend',
                ],
                'park' => [
                    'class' => 'backend\modules\park\Module',
                    'controllerNamespace' => 'backend\modules\park\controllers\backend',
                    'viewPath' => '@backend/modules/park/views/backend',
                ],
                'currency' => [
                    'class' => 'backend\modules\currency\Module',
                    'controllerNamespace' => 'backend\modules\currency\controllers\backend',
                    'viewPath' => '@backend/modules/currency/views/backend',
                ],
                'seo' => [
                    'class' => 'backend\modules\seo\Module',
                    'controllerNamespace' => 'backend\modules\seo\controllers\backend',
                    'viewPath' => '@backend/modules/seo/views/backend',
                ],
            ]
        ],
        'main' => [
            'class' => 'backend\modules\main\Module',
        ],
//        'user' => [
//            'class' => 'backend\modules\user\Module',
//            'controllerNamespace' => 'backend\modules\user\controllers\frontend',
//            'viewPath' => '@backend/modules/user/views/frontend',
//        ],
        'page' => [
            'class' => 'backend\modules\page\Module',
            'controllerNamespace' => 'backend\modules\page\controllers\frontend',
            'viewPath' => '@backend/modules/page/views/frontend',
        ],
        'park' => [
            'class' => 'backend\modules\park\Module',
            'controllerNamespace' => 'backend\modules\park\controllers\frontend',
            'viewPath' => '@backend/modules/park/views/frontend',
        ],
        'news' => [
            'class' => 'backend\modules\news\Module',
            'controllerNamespace' => 'backend\modules\news\controllers\frontend',
            'viewPath' => '@backend/modules/news/views/frontend',
        ],
        'album' => [
            'class' => 'backend\modules\album\Module',
            'controllerNamespace' => 'backend\modules\album\controllers\frontend',
            'viewPath' => '@backend/modules/album/views/frontend',
        ],
        'video' => [
            'class' => 'backend\modules\video\Module',
            'controllerNamespace' => 'backend\modules\video\controllers\frontend',
            'viewPath' => '@backend/modules/video/views/frontend',
        ],
        'press' => [
            'class' => 'backend\modules\press\Module',
            'controllerNamespace' => 'backend\modules\press\controllers\frontend',
            'viewPath' => '@backend/modules/press/views/frontend',
        ],
        'reserve' => [
            'class' => 'backend\modules\reserve\Module',
            'controllerNamespace' => 'backend\modules\reserve\controllers\frontend',
            'viewPath' => '@backend/modules/reserve/views/frontend',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'backend\components\UserIdentity',
            'enableAutoLogin' => true,
            'loginUrl' => ['/admin/user/user/login'],
        ],
        'settings' => [
            'class' => 'backend\modules\settings\components\Settings'
        ],
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],
        'request' => [
            'cookieValidationKey' => 'FUloAT9R2GHje9nEsRHTt9LfEWSOZZeL',
            //@todo langRequest
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
        'seo' => [
            'class' => 'backend\modules\seo\components\Seo',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['94.76.75.20'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
