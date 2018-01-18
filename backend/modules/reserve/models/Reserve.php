<?php

namespace backend\modules\reserve\models;

use backend\modules\park\models\Service;
use yii\db\ActiveRecord;

class Reserve extends ActiveRecord
{
    public function rules()
    {
        return [
            [['country'], 'required', 'message' => 'Выберите страну'],
            [['city'], 'required', 'message' => 'Выберите город'],
            [['place'], 'required', 'message' => 'Выберите местоположение'],
        ];
    }

    public static function secondsToTime($inputSeconds) {

        $secondsInAMinute = 60;
        $secondsInAnHour  = 60 * $secondsInAMinute;
        $secondsInADay    = 24 * $secondsInAnHour;

        $days = floor($inputSeconds / $secondsInADay);

        $hourSeconds = $inputSeconds % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);

        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);

        return [
            'd' => (int) $days,
            'h' => (int) $hours,
            'm' => (int) $minutes,
        ];
    }

    public static function getPeriod($from, $to)
    {
        $period = $to - $from;

        $reserve_period = floor(($period) / 86400);

        if (($period) % 86400 > 7200) {
            $reserve_period++;
        }

        return $reserve_period;
    }

    public static function getProcessServices($period, $services_data)
    {
        $services_data = array_filter($services_data);

        $services = Service::find()
            ->where([Service::tableName() . '.id' => array_keys($services_data)])
            ->joinWith('translation')
            ->indexBy('id')
            ->asArray()
            ->all();

        foreach ($services_data as $service_id => $service) {
            if (isset($services[$service_id])) {
                $services_data[$service_id] = [
                    'quantity' => $service,
                    'title' => $services[$service_id]['translation']['title'],
                    'price' => $period < 15 ? $services[$service_id]['price_1'] : $services[$service_id]['price_15'],
                ];
            } else {
                unset($services_data[$service_id]);
            }
        }

        return $services_data;
    }
}