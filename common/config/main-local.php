<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=iq_vila', //iq_betta
            'username' => 'iq_vila', //iq_bettau
            'password' => 'Ti3bapktOc', //Ti3bapktOcBetaa
            'charset' => 'utf8',
        ],
//                'db' => [
//            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=localhost;dbname=iq_betta',
//            'username' => 'iq_bettau',
//            'password' => 'mJaeShBIOn',
//            'charset' => 'utf8',
//        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.iq-offshore.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'itc@iq-offshore.com',
                'password' => 'Do7shyTIBT23',
                'port' => '587', // Port 25 is a very common port too
                //'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => true,
        ],
    ],
];
