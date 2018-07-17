<?php
namespace frontend\modules\file;

class FileModule extends \common\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'Files',
            'ru' => 'Файлы',
        ],
        'icon' => 'floppy-disk',
        'order_num' => 30,
    ];
}