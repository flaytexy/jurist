<?php
namespace frontend\modules\page;

class PageModule extends \common\components\Module
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
            'en' => 'Pages and newses',
            'ru' => 'Страницы и новости',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}