<?php

namespace app\modules\park\models;

use yii\db\ActiveRecord;

/**
 * Class CityTranslation
 * @package app\modules\park\models
 *
 * @property int $id
 * @property int $city_id
 * @property string $language
 * @property string $title
 * @property int $status
 */
class CityTranslation extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Введите заголовок страницы'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['status'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'language' => 'Язык',
        ];
    }
}
