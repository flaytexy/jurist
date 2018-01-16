<?php

namespace app\modules\press\models;

use app\models\ContentTranslation;

/**
 * Class PressTranslation
 * @package app\modules\press\models
 *
 * @property int $id
 * @property int $content_id
 * @property string $language
 * @property string $title
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class PressTranslation extends ContentTranslation
{
    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Введите заголовок новости'],
            [['slug'], 'required', 'message' => 'Введите постоянную ссылку для новости'],
            //[['slug'], 'unique', 'message' => 'Постоянная ссылка должна быть уникальной'],
            [['short_description'], 'required', 'message' => 'Введите краткое содержание новости'],
            [['description'], 'required', 'message' => 'Введите содержание новости'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['status'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'slug' => 'Постоянная ссылка',
            'short_description' => 'Краткое содержание',
            'description' => 'Содержание',
            'language' => 'Язык',
        ];
    }
}
