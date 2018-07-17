<?php
namespace frontend\modules\orders;

class OrdersModule extends \common\components\Module
{
    public $settings = [
        'mailAdminOnNewOrders' => true,
        'subjectOnNewOrders' => 'New orders',
        'templateOnNewOrders' => '@frontend/modules/orders/mail/en/new_orders',

        'answerTemplate' => '@frontend/modules/orders/mail/en/answer',
        'answerSubject' => 'Answer on your orders message',
        'answerHeader' => 'Hello,',
        'answerFooter' => 'Best regards.',

        'enableTitle' => false,
        'enablePhone' => true,
        'enableCaptcha' => false,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Orders',
            'ru' => 'Заказы',
        ],
        'icon' => 'hopping-cart',
        'order_num' => 60,
    ];
}