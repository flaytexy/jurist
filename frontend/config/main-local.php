<?php

$config = [

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'QpZBsyglyENJ_A1y6sl7FBlKV6BZ_KAN',
        ],


    ],
];



if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    //if(YII_DEBUG){
        $config['bootstrap'][] = 'debug';
        $config['modules']['debug'] = [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '195.211.139.*', '195.200.90.*' ]//, '195.211.139.*']
        ];
    //}

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '195.211.139.*', '1195.200.90.254' ]//, '195.211.139.*']
    ];


}
/*if(YII_ENV_DEV){
    echo '111111111111';exit;
    $config['components']['assetManager']['forceCopy'] = true;
}*/
return $config;