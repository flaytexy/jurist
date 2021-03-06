<?php

namespace backend\modules\park\models;

use yii\db\ActiveRecord;

/**
 * Class BrandTranslation
 * @package backend\modules\park\models
 *
 * @property int $id
 * @property int $brand_id
 * @property string $language
 * @property string $title
 * @property string $slug
 * @property int $status
 */
class BrandTranslation extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Введите заголовок класса'],
            [['slug'], 'required', 'message' => 'Введите постоянную ссылку для класса'],
            //[['slug'], 'unique', 'message' => 'Постоянная ссылка должна быть уникальной'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['status'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'slug' => 'Постоянная ссылка',
            'language' => 'Язык',
        ];
    }
}
