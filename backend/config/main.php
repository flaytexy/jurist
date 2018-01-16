<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'language' => 'en-US', //ru-RU .. en-En
    'sourceLanguage' => 'en-US', //ru-RU
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    //'defaultRoute' => 'order/index',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' => '@app/views/layouts/admin',
            'modules' => [
                'settings' => [
                    'class' => 'app\modules\settings\Module',
                    'sourceLanguage' => 'en'
                ],
                'user' => [
                    'class' => 'app\modules\user\Module',
                    'controllerNamespace' => 'app\modules\user\controllers\backend',
                    'viewPath' => '@app/modules/user/views/backend',
                ],
                'menu' => [
                    'class' => 'app\modules\menu\Module',
                    'controllerNamespace' => 'app\modules\menu\controllers\backend',
                    'viewPath' => '@app/modules/menu/views/backend',
                ],
                'page' => [
                    'class' => 'app\modules\page\Module',
                    'controllerNamespace' => 'app\modules\page\controllers\backend',
                    'viewPath' => '@app/modules/page/views/backend',
                ],
                'news' => [
                    'class' => 'app\modules\news\Module',
                    'controllerNamespace' => 'app\modules\news\controllers\backend',
                    'viewPath' => '@app/modules/news/views/backend',
                ],
                'album' => [
                    'class' => 'app\modules\album\Module',
                    'controllerNamespace' => 'app\modules\album\controllers\backend',
                    'viewPath' => '@app/modules/album/views/backend',
                ],
                'video' => [
                    'class' => 'app\modules\video\Module',
                    'controllerNamespace' => 'app\modules\video\controllers\backend',
                    'viewPath' => '@app/modules/video/views/backend',
                ],
                'press' => [
                    'class' => 'app\modules\press\Module',
                    'controllerNamespace' => 'app\modules\press\controllers\backend',
                    'viewPath' => '@app/modules/press/views/backend',
                ],
                'attachment' => [
                    'class' => 'app\modules\attachment\Module',
                    'controllerNamespace' => 'app\modules\attachment\controllers\backend',
                    'viewPath' => '@app/modules/attachment/views/backend',
                ],
                'park' => [
                    'class' => 'app\modules\park\Module',
                    'controllerNamespace' => 'app\modules\park\controllers\backend',
                    'viewPath' => '@app/modules/park/views/backend',
                ],
                'currency' => [
                    'class' => 'app\modules\currency\Module',
                    'controllerNamespace' => 'app\modules\currency\controllers\backend',
                    'viewPath' => '@app/modules/currency/views/backend',
                ],
                'seo' => [
                    'class' => 'app\modules\seo\Module',
                    'controllerNamespace' => 'app\modules\seo\controllers\backend',
                    'viewPath' => '@app/modules/seo/views/backend',
                ],
            ]
        ],
        'main' => [
            'class' => 'app\modules\main\Module',
        ],
//        'user' => [
//            'class' => 'app\modules\user\Module',
//            'controllerNamespace' => 'app\modules\user\controllers\frontend',
//            'viewPath' => '@app/modules/user/views/frontend',
//        ],
        'page' => [
            'class' => 'app\modules\page\Module',
            'controllerNamespace' => 'app\modules\page\controllers\frontend',
            'viewPath' => '@app/modules/page/views/frontend',
        ],
        'park' => [
            'class' => 'app\modules\park\Module',
            'controllerNamespace' => 'app\modules\park\controllers\frontend',
            'viewPath' => '@app/modules/park/views/frontend',
        ],
        'news' => [
            'class' => 'app\modules\news\Module',
            'controllerNamespace' => 'app\modules\news\controllers\frontend',
            'viewPath' => '@app/modules/news/views/frontend',
        ],
        'album' => [
            'class' => 'app\modules\album\Module',
            'controllerNamespace' => 'app\modules\album\controllers\frontend',
            'viewPath' => '@app/modules/album/views/frontend',
        ],
        'video' => [
            'class' => 'app\modules\video\Module',
            'controllerNamespace' => 'app\modules\video\controllers\frontend',
            'viewPath' => '@app/modules/video/views/frontend',
        ],
        'press' => [
            'class' => 'app\modules\press\Module',
            'controllerNamespace' => 'app\modules\press\controllers\frontend',
            'viewPath' => '@app/modules/press/views/frontend',
        ],
        'reserve' => [
            'class' => 'app\modules\reserve\Module',
            'controllerNamespace' => 'app\modules\reserve\controllers\frontend',
            'viewPath' => '@app/modules/reserve/views/frontend',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
