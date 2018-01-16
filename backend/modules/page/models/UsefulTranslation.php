<?php

namespace app\modules\page\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Class UsefulTranslation
 * @package app\modules\page\models
 *
 * @property int $id
 * @property int $useful_id
 * @property string $language
 * @property string $title
 * @property string $link
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class UsefulTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%content_useful_translation%}}';
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
            [['title'], 'required', 'message' => 'Введите заголовок'],
            [['description'], 'required', 'message' => 'Введите описание'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['status'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'language' => 'Язык',
        ];
    }
}
