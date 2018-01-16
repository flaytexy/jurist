<?php

namespace app\modules\park\models;

use app\modules\attachment\models\Attachment;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class CarPrices
 * @package app\modules\park\models
 *
 * @property int $id
 * @property int $car_id
 * @property string $object
 * @property int $object_id
 * @property int $price_1
 * @property int $price_3
 * @property int $price_6
 * @property int $price_8
 * @property int $price_15
 * @property int $price_29
 * @property int $created_at
 * @property int $updated_at
 */
class CarPrices extends ActiveRecord
{
    public $title = null;

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
            [['car_id'], 'exist', 'targetClass' => Car::className(), 'targetAttribute' => 'id', 'message' => 'Автомобиль не существует'],
            [['price_1', 'price_3', 'price_6', 'price_8', 'price_15', 'price_29'], 'double', 'message' => 'Введите корректную цену'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'price_1' => '1 - 2',
            'price_3' => '3 - 5',
            'price_6' => '6 = 7',
            'price_8' => '8 - 14',
            'price_15' => '15 - 28',
            'price_29' => '29+',
        ];
    }

    public function getCar()
    {
        return $this->hasOne(Car::className(), ['id' => 'car_id'])
            ->from(['car_table' => Car::tableName()]);
    }

    public function getTranslatedCar()
    {
        return $this->getCar()
            ->joinWith('translation');
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'object_id']);
    }

    public function getTranslatedCity()
    {
        return $this->getCity()
            ->joinWith('translation');
    }
}
