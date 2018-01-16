<?php

namespace app\modules\park\models;

use yii\db\ActiveRecord;

/**
 * Class AttributeTranslation
 * @package app\modules\park\models
 *
 * @property int $id
 * @property int $attribute_id
 * @property string $language
 * @property string $title
 * @property string $slug
 * @property int $status
 */
class AttributeTranslation extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Введите заголовок класса'],
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
