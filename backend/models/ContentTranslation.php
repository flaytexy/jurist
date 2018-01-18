<?php

namespace backend\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Class NewsTranslation
 * @package backend\modules\news\models
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
class ContentTranslation extends ActiveRecord
{
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{content_translation}}';
    }


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
            [['title'], 'required', 'message' => 'Введите заголовок новости'],
            [['slug'], 'required', 'message' => 'Введите постоянную ссылку для новости'],
            //[['slug'], 'unique', 'message' => 'Постоянная ссылка должна быть уникальной'],
            [['short_description'], 'required', 'message' => 'Введите краткое содержание новости'],
            [['description'], 'required', 'message' => 'Введите содержание новости'],
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
            'video_link' => 'Ссылка на видео',
        ];
    }
}
