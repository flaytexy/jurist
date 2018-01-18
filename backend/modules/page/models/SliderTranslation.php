<?php

namespace backend\modules\page\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Class SliderTranslation
 * @package backend\modules\page\models
 *
 * @property int $id
 * @property int $slider_id
 * @property string $language
 * @property string $title
 * @property string $link
 * @property string $button_text
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class SliderTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%content_slider_translation%}}';
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
            [['title'], 'required', 'message' => 'Введите заголовок слайда'],
            [['link'], 'safe'],
            [['button_text'], 'safe'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['status'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'link' => 'Ссылка',
            'button_text' => 'Текст кнопки',
            'language' => 'Язык',
        ];
    }
}
