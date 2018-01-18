<?php

namespace backend\modules\page\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Class ServiceTranslation
 * @package backend\modules\page\models
 *
 * @property int $id
 * @property int $service_id
 * @property string $language
 * @property string $title
 * @property string $link
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class ServiceTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%content_service_translation%}}';
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
            [['title'], 'required', 'message' => 'Введите заголовок услуги'],
            [['link'], 'safe'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['status'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'link' => 'Ссылка',
            'language' => 'Язык',
        ];
    }
}
