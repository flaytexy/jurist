<?php
namespace frontend\modules\slidesmall;

class SlidesmallModule extends \frontend\components\Module
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
            'en' => 'Slidesmall',
            'ru' => 'Предожения',
        ],
        'icon' => 'suitcase',
        'order_num' => 70,
    ];
}