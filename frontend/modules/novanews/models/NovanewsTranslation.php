<?php

namespace frontend\modules\novanews\models;

use common\models\ContentTranslation;

/**
 * Class NovanewsTranslation
 * @package frontend\modules\novanews\models
 *
 * @property int $id
 * @property int $content_id
 * @property string $language
 * @property string $title
 * @property string $slug
 * @property string $short
 * @property string $short_description
 * @property string $description
 * @property string $text
 * @property int $public_status
 * @property int $created_at
 * @property int $updated_at
 */
class NovanewsTranslation extends ContentTranslation
{
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Введите заголовок статьи'],
            [['slug'], 'required', 'message' => 'Введите постоянную ссылку для статьи'],
            //[['slug'], 'unique', 'message' => 'Постоянная ссылка должна быть уникальной'],
            //[['short_description'], 'required', 'message' => 'Введите краткое содержание статьи'],
            [['description'], 'required', 'message' => 'Введите содержание статьи'],
            [['language'], 'in', 'range' => ['ru-RU', 'en-US'], 'message' => 'Неверное значение языка'],
            [['public_status'], 'boolean'],
            [['name', 'short_description', 'description', 'meta_title', 'meta_keywords', 'meta_description'], 'trim'],
            [['meta_title', 'meta_keywords', 'meta_description', 'tagNames'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'slug' => 'Постоянная ссылка',
            'short_description' => 'Краткое содержание (до 100)',
            'description' => 'Содержание',
            'language' => 'Язык',
        ];
    }

}
