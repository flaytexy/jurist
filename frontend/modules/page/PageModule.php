<?php
namespace frontend\modules\page;

class PageModule extends \frontend\components\Module
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
            'en' => 'Page and Pages',
            'ru' => 'Страницы и новости',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}