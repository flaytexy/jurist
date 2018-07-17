<?php

namespace common\models;

use yii\base\Model;

class Language extends Model
{
    private static $languages = [
        'ru' => ['id' => 'ru', 'local' => 'ru-RU', 'name' => 'RU', 'title' => 'Русский'],
        'en' => ['id' => 'en', 'local' => 'en-US', 'name' => 'ENG', 'title' => 'Английский'],
        //'ua' => ['id' => 'ua', 'local' => 'uk-UA', 'name' => 'UA', 'title' => 'Украинский'],
    ];
    static $current = null;

    static function getCurrent()
    {
        if (self::$current === null) {
            self::$current = self::getDefaultLanguage();
        }
        return self::$current;
    }

    static function setCurrent($url = null)
    {
        $language = self::getLanguageByUrl($url);
        self::$current = ($language === null) ? self::getDefaultLanguage() : $language;
        \Yii::$app->language = self::$current['local'];
    }

    static function getDefaultLanguage()
    {
        return self::$languages['ru'];
    }

    static function getLanguages()
    {
        return self::$languages;
    }

    static function getLanguageByUrl($url = null)
    {
        if ($url === null) {
            return null;
        } else {
            if (isset(self::$languages[$url])) {
                return self::$languages[$url];
            } else {
                return null;
            }
        }
    }
}