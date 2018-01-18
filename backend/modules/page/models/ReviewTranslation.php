<?php

namespace backend\modules\page\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Class ReviewTranslation
 * @package backend\modules\page\models
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 */
class ReviewTranslation extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Необходимо заполнить'],
            [['description'], 'required', 'message' => 'Необходимо заполнить'],
            [['youtube_link'], 'match', 'pattern' => '/^[\-_0-9a-zA-z]+$/', 'message' => 'Введите корректный YouTube-видео ID'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['status'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'youtube_link' => 'YouTube-видео ID',
            'slug' => 'Постоянная ссылка',
            'description' => 'Содержание',
            'language' => 'Язык',
        ];
    }
}
