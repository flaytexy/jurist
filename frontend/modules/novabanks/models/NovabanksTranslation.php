<?php

namespace frontend\modules\Novabanks\models;

use common\models\ContentTranslation;

/**
 * Class NovabanksTranslation
 * @package frontend\modules\Novabanks\models
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
class NovabanksTranslation extends ContentTranslation
{
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Введите заголовок новости'],
            [['slug'], 'required', 'message' => 'Введите постоянную ссылку для новости'],
            //[['slug'], 'unique', 'message' => 'Постоянная ссылка должна быть уникальной'],
            //[['short_description'], 'required', 'message' => 'Введите краткое содержание новости'],
            [['description'], 'required', 'message' => 'Введите содержание новости'],
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
