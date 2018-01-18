<?php

namespace backend\models;

use Yii;
use yii\base\Object;

class CarAttribute extends Object
{
    public static function getTransmissionList()
    {
        return [
            '1' => Yii::t('app', 'Автоматическая'),
            '2' => Yii::t('app', 'Механическая'),
        ];
    }

    public static function getBodyList()
    {
        return [
            '1' => Yii::t('app', 'Хетчбек'),
            '2' => Yii::t('app', 'Седан'),
            '3' => Yii::t('app', 'Универсал'),
            '4' => Yii::t('app', 'Кабриолет'),
            '5' => Yii::t('app', 'Внедорожник'),
            '6' => Yii::t('app', 'Пикап'),
            '7' => Yii::t('app', 'Минивен'),
        ];
    }

    public static function getEngineList()
    {
        return [
            '1' => Yii::t('app', 'Бензин'),
            '2' => Yii::t('app', 'Дизель'),
            '3' => Yii::t('app', 'Электро'),
        ];
    }

    public static function getSeatList()
    {
        return [
            '1' => Yii::t('app', '1 или 2 человека'), // < 5
            '2' => Yii::t('app', 'С комфортом до 5 человек'), // = 5
            '3' => Yii::t('app', 'С комфортом от 6 человек'), // > 5
        ];
    }
}