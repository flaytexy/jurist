<?php
namespace frontend\modules\seo;

class SeoModule extends \frontend\components\Module
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
            'en' => 'Seo',
            'ru' => 'Seo',
        ],
        'icon' => 'suitcase',
        'order_num' => 70,
    ];
}