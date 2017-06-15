<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$config = [
    'id' => 'app-frontend',
    //'language' => 'en-US',
    'language'=> 'ru-RU',
    //'language' => 'en',
    //'language' => 'uk-UA',
    'sourceLanguage' => 'ru-RU',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@runtime' => '@frontend/runtime'
    ],
    'basePath' => dirname(__DIR__),
    //'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',

    //'defaultRoute' => 'catalog/list',
    /*    'modules' => [
            'admin' => [
                'class' => 'frontend\modules\admin\AdminModule',
            ],
        ],*/
    'components' => [
        'formatter' => [
            'dateFormat' => 'yyyy.MM.dd',
            //'decimalSeparator' => '',
            'thousandSeparator' => ' ',
            'currencyCode' => 'USD',
        ],
        'i18n' => [ // ��� ��������� ���������������
            'translations' => [
                'frontend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@common/messages',
                ],
                'backend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@common/messages',
                ],
                'easyii*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'easyii' => 'admin.php',
                    ]
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        /*        'user' => [
                    'identityClass' => 'common\models\User',
                    'enableAutoLogin' => true,
                    'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
                ],*/
        'user' => [
            'identityClass' => 'frontend\models\Admin',
            'enableAutoLogin' => true,
            'authTimeout' => 86400,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/log/requests.log',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'cart' => [
            'class' => 'yz\shoppingcart\ShoppingCart',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'urlManager' => [
            //'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'class'=>'frontend\components\LangUrlManager',
            //'languages' => ['ru' => 'ru-RU', 'en' => 'en-US', 'uk' => 'uk-UA'],
            'rules' => [
                '' => 'site/index',
                'offshornyie-predlozheniya' => 'offers/index',
//                [
//                    'pattern' => 'offshornyie-predlozheniya',
//                    'route' => 'offers/index',
//                    'defaults' => [
//                        'type_id' => 1
//                    ],
//                ],
//                [
//                    'pattern' => 'evropejskie-kompanii',
//                    'route' => 'offers/index',
//                    'defaults' => [
//                        'type_id' => 2
//                    ],
//                ],
                [
                    'pattern' => '/news/tag/<tag:[\w- ]+>',
                    'route' => 'news/index',
                ],
                [
                    'pattern' => '<slug:spisok-offshorov>',
                    'route' => 'news/index',
                    'defaults' => [
                        'type' => 6
                    ],
                ],
                [
                    'pattern' => '<controller:\w+>\-category/<slug:[\w-]+>',
                    'route' => '<controller>/index',
                ],
                [
                    'pattern' => '<controller:\w+>/c/<slug:[\w-]+>',
                    'route' => '<controller>/index',
                ],

                //'<alias:index|search|detail|result|hospital>' => 'site/<alias>',
                '<name:(licenses|offshore|processing|fonds|sale)>/page<page:\d+>' => 'pages/index',
                '<name:(licenses|offshore|processing|fonds|sale)>' => 'pages/index',
                '<name:(licenses|offshore|processing|fonds|sale)>/<slug:[\w-]+>' => 'pages/view',

                '<controller:\w+>/page<page:\d+>' => '<controller>/index',

                '<name:(offers|news|banks)>/<slug:[\w-]+>' => '<name>/view',
                '<controller:\w+>/view/<slug:[\w-]+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/cat/<slug:[\w-]+>' => '<controller>/cat',
                'admin/<controller:\w+>/<action:[\w-]+>/<id:\d+>' => 'admin/<controller>/<action>',
                'admin/<module:\w+>/<controller:\w+>/<action:[\w-]+>/<id:\d+>' => 'admin/<module>/<controller>/<action>',
            ],
        ],

        'assetManager' => [
            // uncomment the following line if you want to auto update your assets (unix hosting only)
            //'linkAssets' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [YII_DEBUG ? 'jquery.js' : 'jquery.min.js'],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [YII_DEBUG ? 'css/bootstrap.css' : 'css/bootstrap.min.css'],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [YII_DEBUG ? 'js/bootstrap.js' : 'js/bootstrap.min.js'],
                ],
            ],
        ],
//        'googleApi' => [
//                'class'                 => '\skeeks\yii2\googleApi\GoogleApiComponent',
//                'developer_key'         => 'AIzaSyDin6H0q9dw6l6ATB2MQlvz5vdsNd9HDa4',
//        ]
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'root' => [
                'baseUrl'=>'@web',
                'basePath'=>'@webroot',
                'path' => 'uploads',
                'name' => 'Global'
            ],
            /*                'watermark' => [
                                'source'         => __DIR__.'/logo.png', // Path to Water mark image
                                'marginRight'    => 5,          // Margin right pixel
                                'marginBottom'   => 5,          // Margin bottom pixel
                                'quality'        => 95,         // JPEG image save quality
                                'transparency'   => 70,         // Water mark image transparency ( other than PNG )
                                'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
                                'targetMinPixel' => 200         // Target image minimum pixel size
                            ]*/
        ]
    ],
    'params' => $params,
    'modules' => [
        'admin' => [
            'class' => 'frontend\modules\admin\AdminModule',
        ],
    ],
    'bootstrap' => [
        'admin',
        'log',
        //'debug',
        'gii'
    ]

];

if(YII_ENV_DEV){

    $config['components']['assetManager']['forceCopy'] = true;
}

return $config;

