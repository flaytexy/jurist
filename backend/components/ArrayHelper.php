<?php

namespace backend\components;

use yii\helpers\BaseArrayHelper;

class ArrayHelper extends BaseArrayHelper
{
    public static function strval($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = static::toArray($value);
                } else {
                    $array[$key] = strval($value);
                }
            }

            return $array;
        } else {
            return strval($array);
        }
    }
}