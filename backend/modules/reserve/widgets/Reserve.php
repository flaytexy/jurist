<?php
namespace backend\modules\reserve\widgets;

use backend\modules\park\models\Place;
use backend\modules\park\models\PlaceTranslation;
use Yii;
use backend\modules\park\models\City;
use yii\base\Widget;

class Reserve extends Widget
{
    public $button_text;

    public function init()
    {
        parent::init();

        if ($this->button_text === null) {
            $this->button_text = Yii::t('app', 'Поиск');
        }
    }

    public function run()
    {
        $countries = [];

        $reserve_data = Yii::$app->session->get('reserve');

        $cities = City::getParkCities();

        // Подача
        if (isset($reserve_data['city']) && isset($cities[$reserve_data['city']])) {
            $city = [
                'value' => $cities[$reserve_data['city']]['id'],
                'text' => $cities[$reserve_data['city']]['translation']['title'],
            ];

            $places = Place::find()
                ->select([
                    Place::tableName() . '.id',
                    PlaceTranslation::tableName() . '.title',
                ])
                ->where([Place::tableName() . '.city_id' => $city['value']])
                ->joinWith('translation', false)
                ->indexBy('id')
                ->asArray()
                ->all();
        } else {
            $city = [
                'value' => '',
                'text' => Yii::t('app', 'Выберите город'),
            ];

            $places = [
                [
                    'id' => '',
                    'title' => Yii::t('app', 'Выберите город'),
                ]
            ];
        }

        if (isset($reserve_data['place']) && isset($places[$reserve_data['place']])) {
            $place = [
                'value' => $places[$reserve_data['place']]['id'],
                'text' => $places[$reserve_data['place']]['title'],
            ];
        } else {
            $place = [
                'value' => '',
                'text' => Yii::t('app', 'Выберите место'),
            ];
        }

        if (isset($reserve_data['other_out']) && $reserve_data['other_out']) {
            $other_out = true;
        } else {
            $other_out = false;
        }

        // Возврат
        if (isset($reserve_data['other_city']) && isset($cities[$reserve_data['other_city']])) {
            $other_city = [
                'value' => $cities[$reserve_data['other_city']]['id'],
                'text' => $cities[$reserve_data['other_city']]['translation']['title'],
            ];

            $other_places = Place::find()
                ->select([
                    Place::tableName() . '.id',
                    PlaceTranslation::tableName() . '.title',
                ])
                ->where([Place::tableName() . '.city_id' => $other_city['value']])
                ->joinWith('translation', false)
                ->indexBy('id')
                ->asArray()
                ->all();
        } else {
            $other_city = [
                'value' => '',
                'text' => Yii::t('app', 'Выберите город'),
            ];

            $other_places = [
                [
                    'id' => '',
                    'title' => Yii::t('app', 'Выберите город'),
                ]
            ];
        }

        if (isset($reserve_data['other_place']) && isset($other_places[$reserve_data['other_place']])) {
            $other_place = [
                'value' => $other_places[$reserve_data['other_place']]['id'],
                'text' => $other_places[$reserve_data['other_place']]['title'],
            ];
        } else {
            $other_place = [
                'value' => '',
                'text' => Yii::t('app', 'Выберите место'),
            ];
        }

        if (isset($reserve_data['date_in']) && $reserve_data['date_in']) {
            $date_in = $reserve_data['date_in'];
        } else {
            $date_in = date('d.m.Y', strtotime('+2 days'));
        }
        if (isset($reserve_data['time_in']) && $reserve_data['time_in']) {
            $time_in = $reserve_data['time_in'];
        } else {
            $time_in = '10:00';
        }
        if (isset($reserve_data['date_out']) && $reserve_data['date_out']) {
            $date_out = $reserve_data['date_out'];
        } else {
            $date_out = date('d.m.Y', strtotime('+5 days'));
        }
        if (isset($reserve_data['time_out']) && $reserve_data['time_out']) {
            $time_out = $reserve_data['time_out'];
        } else {
            $time_out = '10:00';
        }

        return $this->render('_form', [
            'car_id' => Yii::$app->request->post('car_id'),
            'button_text' => $this->button_text,
            'countries' => $countries,
            'cities' => $cities,
            'city' => $city,
            'places' => $places,
            'place' => $place,
            'other_out' => $other_out,
            'other_city' => $other_city,
            'other_places' => $other_places,
            'other_place' => $other_place,
            'date_in' => $date_in,
            'time_in' => $time_in,
            'date_out' => $date_out,
            'time_out' => $time_out,
        ]);
    }
}