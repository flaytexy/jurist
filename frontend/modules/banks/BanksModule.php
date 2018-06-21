<?php
namespace frontend\modules\banks;

class BanksModule extends \common\components\Module
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
            'en' => 'Banks',
            'ru' => 'Предожения',
        ],
        'icon' => 'suitcase',
        'order_num' => 70,
    ];
}