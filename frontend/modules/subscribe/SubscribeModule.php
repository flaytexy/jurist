<?php
namespace frontend\modules\subscribe;

class SubscribeModule extends \frontend\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'E-mail subscribe',
            'ru' => 'E-mail рассылка',
        ],
        'icon' => 'envelope',
        'order_num' => 10,
    ];
}