<?php

namespace app\modules\park\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Place
 * @package app\modules\park\models
 *
 * @property int $id
 * @property int $city_id
 *
 * @property PlaceTranslation|array $translations
 */
class Place extends ActiveRecord
{
    public $language = 'ru-RU';

    private $_title = null;
    private $_edit_link = null;

    public function afterFind()
    {
        if (is_null($this->_title)) {
            foreach ($this->translations as $language => $translation) {
                if ($translation->title) {
                    $this->_title = $translation->title;
                    $this->_edit_link = Url::to(['/admin/park/place/edit', 'id' => $this->id, 'language' => $language]);
                    break;
                }
            }
        }

        parent::afterFind();
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getEditLink()
    {
        return $this->_edit_link;
    }

    public function rules()
    {
        return [
            [['language'], 'safe'],

            [['city_id'], 'required', 'message' => 'Выберите город'],
            [['city_id'], 'exist', 'targetClass' => City::className(), 'targetAttribute' => 'id', 'message' => 'Город не существует'],

            [['time_in_1', 'time_in_2', 'time_in_3', 'time_in_4', 'time_in_5', 'time_in_6', 'time_in_7'], 'date', 'format' => 'php:H:i', 'message' => 'Неправильный формат времени'],
            [['time_out_1', 'time_out_2', 'time_out_3', 'time_out_4', 'time_out_5', 'time_out_6', 'time_out_7'], 'date', 'format' => 'php:H:i', 'message' => 'Неправильный формат времени'],

            [['price_airport_work_time', 'price_airport_not_work_time'], 'required', 'message' => 'Введите значение'],
            [['price_out_office_work_time', 'price_out_city_work_time', 'price_out_airport_work_time'], 'required', 'message' => 'Введите значение'],
            [['price_out_office_not_work_time', 'price_out_city_not_work_time', 'price_out_airport_not_work_time'], 'required', 'message' => 'Введите значение'],
            [['price_in_office_work_time', 'price_in_city_work_time', 'price_in_airport_work_time'], 'required', 'message' => 'Введите значение'],
            [['price_in_office_not_work_time', 'price_in_city_not_work_time', 'price_in_airport_not_work_time'], 'required', 'message' => 'Введите значение'],

            [['price_airport_work_time', 'price_airport_not_work_time'], 'double'],
            [['price_out_office_work_time', 'price_out_city_work_time', 'price_out_airport_work_time'], 'double'],
            [['price_out_office_not_work_time', 'price_out_city_not_work_time', 'price_out_airport_not_work_time'], 'double'],
            [['price_in_office_work_time', 'price_in_city_work_time', 'price_in_airport_work_time'], 'double'],
            [['price_in_office_not_work_time', 'price_in_city_not_work_time', 'price_in_airport_not_work_time'], 'double'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'city_id' => 'Город',

            'time_in_1' => 'Понедельник',
            'time_in_2' => 'Вторник',
            'time_in_3' => 'Среда',
            'time_in_4' => 'Четверг',
            'time_in_5' => 'Пятница',
            'time_in_6' => 'Суббота',
            'time_in_7' => 'Воскресенье',

            'time_out_1' => 'Понедельник',
            'time_out_2' => 'Вторник',
            'time_out_3' => 'Среда',
            'time_out_4' => 'Четверг',
            'time_out_5' => 'Пятница',
            'time_out_6' => 'Суббота',
            'time_out_7' => 'Воскресенье',

            'price_airport_work_time' => 'рабочее время',
            'price_airport_not_work_time' => 'не рабочее время',

            'price_out_office_work_time' => 'центральный офис',
            'price_out_office_not_work_time' => 'центральный офис',
            'price_out_city_work_time' => 'город',
            'price_out_city_not_work_time' => 'город',
            'price_out_airport_work_time' => 'аэропорт',
            'price_out_airport_not_work_time' => 'аэропорт',

            'price_in_office_work_time' => 'центральный офис',
            'price_in_office_not_work_time' => 'центральный офис',
            'price_in_city_work_time' => 'город',
            'price_in_city_not_work_time' => 'город',
            'price_in_airport_work_time' => 'аэропорт',
            'price_in_airport_not_work_time' => 'аэропорт',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(PlaceTranslation::className(), ['place_id' => 'id'])
            ->indexBy('language');
    }

    public function getTranslation()
    {
        return $this->hasOne(PlaceTranslation::className(), ['place_id' => 'id'])
            ->andWhere([
                PlaceTranslation::tableName() . '.status' => PlaceTranslation::STATUS_PUBLISHED,
                PlaceTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id'])
            ->with('translations');
    }
}
