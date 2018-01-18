<?php

namespace backend\modules\album\models;

use backend\models\ContentTranslation;

/**
 * Class AlbumTranslation
 * @package backend\modules\album\models
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
class AlbumTranslation extends ContentTranslation
{
    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Введите заголовок галереи'],
            [['slug'], 'required', 'message' => 'Введите постоянную ссылку для галереи'],
            //[['slug'], 'unique', 'message' => 'Постоянная ссылка должна быть уникальной'],
            [['short_description'], 'required', 'message' => 'Введите краткое содержание галереи'],
            [['description'], 'required', 'message' => 'Введите содержание галереи'],
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
