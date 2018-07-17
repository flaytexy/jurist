<?php
namespace frontend\modules\offers;

class OffersModule extends \common\components\Module
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
        'icon' => 'suitcase',
        'order_num' => 70,
    ];
}