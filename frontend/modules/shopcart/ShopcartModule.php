<?php
namespace frontend\modules\shopcart;

class ShopcartModule extends \frontend\components\Module
{
    public $settings = [
        'mailAdminOnNewOrder' => true,
        'subjectOnNewOrder' => 'New order',
        'templateOnNewOrder' => '@frontend/modules/shopcart/mail/en/new_order',
        'subjectNotifyUser' => 'Your order status changed',
        'templateNotifyUser' => '@frontend/modules/shopcart/mail/en/notify_user',
        'frontendShopcartRoute' => '/shopcart/order',
        'enablePhone' => true,
        'enableEmail' => true
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Orders',
            'ru' => 'Заказы',
        ],
        'icon' => 'shopping-cart',
        'order_num' => 120,
    ];
}