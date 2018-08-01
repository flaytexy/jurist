<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Class NewsTranslation
 * @package app\modules\news\models
 *
 * @property int $id
 * @property int $content_id
 * @property string $language
 * @property string $name
 * @property string $slug
 * @property string $short_description
 * @property string $description
 *
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_h1
 *
 * @property int $public_status
 * @property int $created_at
 * @property int $updated_at
 */
class ContentTranslation extends ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;


    public static function primaryKey()
    {
        return ['id'];
    }

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

            [['name'], 'required', 'message' => 'Введите заголовок новости'],
            [['slug'], 'required', 'message' => 'Введите постоянную ссылку для новости'],
            //[['slug'], 'unique', 'message' => 'Постоянная ссылка должна быть уникальной'],
            //[['short_description'], 'required', 'message' => 'Введите краткое содержание новости'],
            [['description'], 'required', 'message' => 'Введите содержание новости'],
            [['language'], 'in', 'range' => ['ru-RU', 'en-US'], 'message' => 'Неверное значение языка'], // 'uk-UA',
            [['public_status'], 'boolean'],
            [['video_link'], 'string'],
            [['name', 'short_description', 'description', 'meta_title', 'meta_keywords', 'meta_description', 'meta_h1'], 'trim'],
            [['meta_title', 'meta_keywords', 'meta_description', 'meta_h1', 'tagNames'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Заголовок',
            'slug' => 'Постоянная ссылка',
            'short_description' => 'Краткое содержание',
            'description' => 'Содержание',
            'language' => 'Язык',
            'video_link' => 'Ссылка на видео',
        ];
    }


    /**
     * Formats all model errors into a single string
     * @return string
     */
    public function formatErrors()
    {
        $result = '';
        foreach($this->getErrors() as $attribute => $errors) {
            $result .= implode(" ", $errors)." ";
        }
        return $result;
    }
}
