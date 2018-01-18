<?php
namespace frontend\modules\news;

class NewsModule extends \frontend\components\Module
{
    public $settings = [
        'enableThumb' => true,
        'enablePhotos' => true,
        'enableShort' => true,
        'shortMaxLength' => 256,
        'enableTags' => true
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'News',
            'ru' => 'Новости',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}