<?php
namespace frontend\modules\offers;

class OffersModule extends \frontend\components\Module
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
            'en' => 'Offers',
            'ru' => 'Предожения',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}