<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$config = [
    'id' => 'app-frontend',
    'language' => 'ru-RU', // en-US
    'sourceLanguage' => 'en',

    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@runtime' => '@frontend/runtime',
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset'
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
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@frontend/runtime/cache',
        ],
//        'cache' => [
//            'class' => 'yii\caching\MemCache',
//            'servers' => [
//                [
//                    'host' => 'localhost',
//                    'port' => 11211,
//                ],
//            ],
//            'useMemcached' => true,
//        ],
        'i18n' => [ // ��� ��������� ���������������
            'translations' => [
                'frontend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath' => '@common/messages',
                ],
                'backend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath' => '@common/messages',
                ],
                'easyii*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'easyii' => 'translate.php',
                    ]
                ],
            ],
        ],
        'request' => [
            'class' => 'frontend\components\LangRequest',
            'csrfParam' => '_csrf-frontend'
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
//            'targets' => [
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning'],
//                    'logFile' => '@runtime/log/requests.log',
//                    //'prefix' => function ($message) { //formatter
//                    //    $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
//                    //    $userID = $user ? $user->getId(false) : '-';
//                    //    return "[$userID]";
//                    //}
//                ],
//            ],
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/log/requests_all.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                    //'logVars' => ['GET', 'POST'], // log some globals
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                    'logFile' => '@runtime/log/requests_error.log',
                    //'logVars' => ['GET', 'POST'], // log some globals
                ],
//                '404_mail' => [
//                    'class' => 'yii\log\EmailTarget',
//                    'categories' => ['yii\web\HttpException:404'],
//                    'message' => [
//                        'from' => ['itc@iq-offshore.com' => 'Iq-offshore.com'], //от кого
//                        'to' => ['akvamiris@gmail.com'], //кому
//                        'subject' => '404 ошибка на саайте', //тема
//                    ],
//                ],
                '404_file' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'categories' => ['yii\web\HttpException:404'],
                    //'logVars' => [], //не добавлять в лог глобальные переменные ($_SERVER, $_SESSION...)
                    'logFile' => '@runtime/logs/404.log',
                ],
                'delete_end_truncate' => [
                    'class' => 'yii\log\EmailTarget',
                    'categories' => ['delete_end_truncate'],
                    'message' => [
                        'from' => ['itc@iq-offshore.com' => 'Iq-offshore.com'], //от кого
                        'to' => ['akvamiris@gmail.com'], //кому
                        'subject' => 'Попитка delete_end_truncate', //тема
                    ],
                    //'logVars' => [] //не добавлять в лог глобальные переменные ($_SERVER, $_SESSION...)
                ],
                'delete_end_truncate_file' => [
                    'class' => 'yii\log\FileTarget',
                    //'levels' => ['error', 'warning'],
                    'categories' => ['delete_end_truncate'],
                    //'logVars' => [], //не добавлять в лог глобальные переменные ($_SERVER, $_SESSION...)
                    'logFile' => '@runtime/logs/delete_end_truncate.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
//                [
//                    'class' => 'yii\log\EmailTarget', //шлет на e-mail
//                    'categories' => ['payment_success'],
//                    'mailer' => 'yii\swiftmailer\Mailer',
//                    'logVars' => [],
//                    'message' => [
//                        'from' => ['admin@site.com' => 'НАЗВАНИЕ САЙТА'], //от кого
//                        'to' => ['mail@gmail.com'], //кому
//                        'subject' => 'Получен платеж. Лог в теле сообщения.', //тема
//                    ],
//                ],
//                'email' => [
//                    'class' => 'yii\log\EmailTarget',
//                    'except' => ['yii\web\HttpException:404'],
//                    'levels' => ['error', 'warning'],
//                    'message' => ['from' => 'robot@iq-offshore.com', 'to' => 'akvamiris@gmail.com'],
//                ],
//
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['info'],
//                    'categories' => ['orders'],
//                    'logFile' => '@app/runtime/logs/Orders/requests.log',
//                    'maxFileSize' => 1024 * 2,
//                    'maxLogFiles' => 20,
//                ],
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['info'],
//                    'categories' => ['pushNotifications'],
//                    'logFile' => '@app/runtime/logs/Orders/notification.log',
//                    'maxFileSize' => 1024 * 2,
//                    'maxLogFiles' => 50,
//                ],
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error'],
//                    'logFile' => '@app/runtime/logs/Orders/my_error.log',
//                    'maxFileSize' => 1024 * 2,
//                    'maxLogFiles' => 50,
//                ],
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
            //'class' => 'yii\web\UrlManager',
            'class' => 'frontend\components\LangUrlManager',
            //'languages' => ['ru' => 'ru-RU', 'en' => 'en-US', 'uk' => 'uk-UA'],
            'rules' => [
                '' => 'site/index',
                'offshornyie-predlozheniya' => 'offers/index',
                'banks' => 'novabanks/index',
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
//                [ // del
//                    'pattern' => '/news/tag/<tag:[\w- ]+>',
//                    'route' => 'news/index',
//                ],
                [
                    'pattern' => '<slug:spisok-offshorov>',
                    'route' => 'news/index',
                    'defaults' => [
                        'type' => 6
                    ],
                ],
                [
                    'pattern' => '<controller:\w+>-category/<slug:[\w-]+>',
                    'route' => '<controller>/index',
                ],
                [
                    'pattern' => '<controller:\w+>/c/<slug:[\w-]+>',
                    'route' => '<controller>/index',
                ],

                //'<alias:index|search|detail|result|hospital>' => 'site/<alias>', ////
                //'<name:(licenses|offshore|processing|fonds|sale)>/page<page:\d+>' => 'pages/index',   //@todo
                //'<name:(licenses|offshore|processing|fonds|sale)>' => 'pages/index',                  //@todo
                //'<name:(licenses|offshore|processing|fonds|sale)>/<slug:[\w-]+>' => 'pages/view',     //@todo
                '<name:(licenses|offshore|processing|fonds|sale)>/page<page:\d+>' => 'novanews/index',
                '<name:(licenses|offshore|processing|fonds|sale)>' => 'novanews/index',
                '<name:(licenses|offshore|processing|fonds|sale)>/<slug:[\w-]+>' => 'novanews/view',

                '<controller:\w+>/tag/<tag:[\w- ]+>' => '<controller>/index',
                //'<controller:\w+>/page<page:\d+>' => '<controller>/index',                            //@todo
                '<controller:\w+>/page<page:\d+>' => '<controller>/index',

                '<name:(offers|news)>/<slug:[\w-]+>' => '<name>/view',
                '<name:(banks|novabanks)>/<slug:[\w-]+>' => 'novabanks/view', //'banks/view',
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
//                'yii\web\JqueryAsset' => [
//                    //'js' => [YII_DEBUG ? 'jquery.js' : 'jquery.min.js']
//                    //'js' => [YII_DEBUG ? '//code.jquery.com/jquery-2.2.4.js' : '//code.jquery.com/jquery-2.2.4.min.js']
//                    'js' => [
//                        YII_DEBUG ? '//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js' : '//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js',
//                        //'//code.jquery.com/jquery-1.12.4.js',
//                        //YII_DEBUG ? '//code.jquery.com/jquery-migrate-1.4.1.js' : '//code.jquery.com/jquery-migrate-1.4.1.min.js',
//                        YII_DEBUG ? '//code.jquery.com/jquery-migrate-3.0.1.js' : '//code.jquery.com/jquery-migrate-3.0.1.min.js'
//                    ]
//                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        //YII_DEBUG ? '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' : '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css',
                        //YII_DEBUG ? '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' : '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css'
                        '//stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css',
                    ],
                ],
//                'yii\bootstrap\BootstrapAsset' => [
//                    //'css' => [],
//                    'css' => [
//                        //YII_DEBUG ? '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' : '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'
//                        //'//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
//                        '//stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css',
//                        '//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css',
//                    ],
//                ],
//                'yii\jui\JuiAsset' => [
//                    'css' => [],
////                    'css' => [
////                        YII_DEBUG ? '//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css' : '//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css'
////                        //YII_DEBUG ? '//code.jquery.com/ui/1.7.2/themes/smoothness/jquery-ui.css' : '//code.jquery.com/ui/1.7.2/themes/smoothness/jquery-ui.css'
////                    ],
//                    'js' => [
//                        YII_DEBUG ? '//code.jquery.com/ui/1.12.1/jquery-ui.js' : '//code.jquery.com/ui/1.12.1/jquery-ui.min.js'
//                        //YII_DEBUG ? '//code.jquery.com/ui/1.7.2/jquery-ui.min.js' : '//code.jquery.com/ui/1.7.2/jquery-ui.min.js'
//                    ],
//                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        //YII_DEBUG ? '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.js' : '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js',
                        //YII_DEBUG ? '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.js' : '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js'
                        '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js',
                        '//stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js'
                    ],
                ],
            ],
        ],
//        'view' => [
//            'class' => '\rmrevin\yii\minify\View',
//            'base_path' => $_SERVER['DOCUMENT_ROOT'], // path to web base,
//            'minify_path' => '@app/web/minify', // path to save minify result
//        ],

        'view' => [
            'class' => '\rmrevin\yii\minify\View',
            //'enableMinify' => !YII_DEBUG,
            'enableMinify' => true,
            'concatCss' => true, // concatenate css
            'minifyCss' => true, // minificate css
            'concatJs' => true, // concatenate js
            'minifyJs' => false, // minificate js
            'minifyOutput' => false, // minificate result html page
            'webPath' => '@web', // path alias to web base
            'basePath' => '@webroot', // path alias to web base
            'minifyPath' => '@webroot/minify', // path alias to save minify result
            'jsPosition' => [ \yii\web\View::POS_END ], // positions of js files to be minified
            'forceCharset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
            'expandImports' => true, // whether to change @import on content
            'compressOptions' => ['extra' => true], // options for compress
            'excludeFiles' => [
                'jquery.js',  // exclude this file from minification
                'jquery-ui.js',
                'app-[^.].js', // you may use regexp
                'styles.css',
                'style_all.css',
                'style_all.min.css',
                'admin.css',
                'ckeditor',
                'ooo.css'
            ]
        ],

//        'googleApi' => [
//                'class'                 => '\skeeks\yii2\googleApi\GoogleApiComponent',
//                'developer_key'         => 'AIzaSyDin6H0q9dw6l6ATB2MQlvz5vdsNd9HDa4',
//        ],

//        'view' => [
//            'class' => '\rmrevin\yii\minify\View',
//            'enableMinify' => !YII_DEBUG,
//            'concatCss' => true, // concatenate css
//            'minifyCss' => true, // minificate css
//            'concatJs' => true, // concatenate js
//            'minifyJs' => true, // minificate js
//            'minifyOutput' => true, // minificate result html page
//            'webPath' => '@web', // path alias to web base
//            'basePath' => '@webroot', // path alias to web base
//            'minifyPath' => '@webroot/minify', // path alias to save minify result
//            'jsPosition' => [ \yii\web\View::POS_END ], // positions of js files to be minified
//            'forceCharset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
//            'expandImports' => true, // whether to change @import on content
//            'compressOptions' => ['extra' => true], // options for compress
//            'excludeFiles' => [
//                'jquery.js', // exclude this file from minification
//                'app-[^.].js', // you may use regexp
//            ],
//        ],
//        'view' => [
//            'class' => '\rmrevin\yii\minify\View',
//            'base_path' => '@app/web', // path alias to web base
//            'minify_path' => '@app/web/minify', // path alias to save minify result
//            'force_charset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
//            'expand_imports' => true, // whether to change @import on content
//        ]
        // ...
//        'view' => [
//            'class' => '\rmrevin\yii\minify\View',
//            'enableMinify' => !YII_DEBUG,
//            'concatCss' => true, // concatenate css
//            'minifyCss' => true, // minificate css
//            'concatJs' => true, // concatenate js
//            'minifyJs' => true, // minificate js
//            'minifyOutput' => true, // minificate result html page
//            'webPath' => '@web', // path alias to web base
//            'basePath' => '@webroot', // path alias to web base
//            'minifyPath' => '@webroot/minify', // path alias to save minify result
//            'jsPosition' => [ \yii\web\View::POS_END ], // positions of js files to be minified
//            'forceCharset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
//            'expandImports' => true, // whether to change @import on content
//            'compressOptions' => ['extra' => true], // options for compress
//            'excludeFiles' => [
//                'jquery.js', // exclude this file from minification
//                'app-[^.].js', // you may use regexp
//            ],
//        ]
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'root' => [
                'baseUrl' => '@web',
                'basePath' => '@webroot',
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
//        'admin' => [
//            'class' => 'frontend\modules\admin\AdminModule',
//        ],
//        'novanews' => [
//            'class' => 'frontend\modules\novanews\Module',
//            'controllerNamespace' => 'frontend\modules\novanews\controllers\frontend',
//            'viewPath' => '@frontend/modules/novanews/views/frontend',
//        ],
//        'news' => [
//            'class' => 'frontend\modules\news\Module',
//            'controllerNamespace' => 'frontend\modules\news\controllers\frontend',
//            'viewPath' => '@frontend/modules/news/views/frontend',
//        ],
        //'novanews' => ['class' => 'frontend\modules\novanews\Module'],

        'admin' => [
            'class' => 'frontend\modules\admin\AdminModule',
            'layout' => '@frontend/modules/admin/views/layouts/main.php', //"@app/views/layouts/main.old.php";
            'modules' => [
                'novanews' => [
                    'class' => 'frontend\modules\novanews\Module',
                    'controllerNamespace' => 'frontend\modules\novanews\controllers\backend',
                    'viewPath' => '@frontend/modules/novanews/views/backend',
                ],

                'novabanks' => [
                    'class' => 'frontend\modules\novabanks\Module',
                    'controllerNamespace' => 'frontend\modules\novabanks\controllers\backend',
                    'viewPath' => '@frontend/modules/novabanks/views/backend',
                ],

                'attachment' => [
                    'class' => 'common\modules\attachment\Module',
                    'controllerNamespace' => 'common\modules\attachment\controllers\backend',
                    'viewPath' => '@common/modules/attachment/views/backend',
                ],
            ],
        ],
    ],
    'bootstrap' => [
        'admin',
        'log',
        'debug',
        //'gii',
        'frontend\modules\novanews\Bootstrap',
        'frontend\modules\novabanks\Bootstrap'
    ]

];

if (YII_ENV_DEV) {

    $config['components']['assetManager']['forceCopy'] = true;
}

return $config;

