<?php
namespace frontend\modules\tickers;

class TickersModule extends \frontend\components\Module
{
    public $settings = [
        'enableThumb2' => true,
        'enablePreImage' => true,
        'enablePhotos' => true,
        'enableShort' => true,
        'enablePreText' => true,
        'shortMaxLength' => 256,
        'enableTags' => true
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Tickers',
            'ru' => 'Предожения',
        ],
        'icon' => 'suitcase',
        'order_num' => 70,
    ];
}