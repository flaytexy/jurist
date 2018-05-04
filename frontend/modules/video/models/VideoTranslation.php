<?php

namespace frontend\modules\video\models;

use common\models\ContentTranslation;

/**
 * Class VideoTranslation
 * @package app\modules\video\models
 *
 * @property int $id
 * @property int $content_id
 * @property string $language
 * @property string $title
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property int $status
 * @property string $video_link
 * @property int $created_at
 * @property int $updated_at
 */
class VideoTranslation extends ContentTranslation
{
    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Введите заголовок новости'],
            [['slug'], 'required', 'message' => 'Введите постоянную ссылку для новости'],
            //[['slug'], 'unique', 'message' => 'Постоянная ссылка должна быть уникальной'],
            [['short_description'], 'string', 'message' => 'Введите краткое содержание новости'],
            [['description'], 'string', 'message' => 'Введите содержание новости'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['status'], 'boolean'],
            [['video_link'], 'string'],
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
