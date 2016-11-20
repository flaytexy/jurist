<?php
namespace frontend\modules\offers;

class OffersModule extends \frontend\components\Module
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
            'en' => 'Offers',
            'ru' => 'Предожения',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}