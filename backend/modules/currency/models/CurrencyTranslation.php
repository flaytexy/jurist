<?php

namespace backend\modules\currency\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Class CurrencyTranslation
 * @package backend\modules\currency\models
 *
 * @property int $id
 * @property int $currency_id
 * @property string $language
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class CurrencyTranslation extends ActiveRecord
{
    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Введите заголовок валюты'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['before', 'after', 'decimals', 'dec_point', 'thousands_sep'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'language' => 'Язык',
            'before' => 'Текст перед значением',
            'after' => 'Текст после значения',
            'decimals' => 'Число знаков после запятой',
            'dec_point' => 'Разделитель дробной части',
            'thousands_sep' => 'Разделитель тысяч',
        ];
    }
}
