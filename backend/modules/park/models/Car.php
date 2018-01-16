<?php

namespace app\modules\park\models;

use Yii;
use app\modules\attachment\models\Attachment;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * Class Car
 * @package app\modules\park\models
 *
 * @property int $id
 * @property int $show_in_homepage
 * @property int $created_at
 * @property int $updated_at
 */
class Car extends ActiveRecord
{
    const DISCOUNT_TYPE_FIXED = 'F';
    const DISCOUNT_TYPE_PERCENT = 'P';

    public $attributeValues = [];

    public $language = 'ru-RU';

    private $_title = null;
    private $_edit_link = null;

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
            [['show_in_homepage'], 'boolean'],
            [['thumbnail'], 'exist', 'targetClass' => Attachment::className(), 'targetAttribute' => 'id', 'message' => 'Изображение не существует'],
            [['attributeValues'], 'safe'],
            [['sticker_id'], 'exist', 'targetClass' => Sticker::className(), 'targetAttribute' => 'id', 'message' => 'Стикер не существует'],
            [['brand_id'], 'required', 'message' => 'Выберите марку'],
            [['brand_id'], 'exist', 'targetClass' => Brand::className(), 'targetAttribute' => 'id', 'message' => 'Марка не существует'],
            [['model_id'], 'required', 'message' => 'Выберите модель'],
            [['model_id'], 'exist', 'targetClass' => Model::className(), 'targetAttribute' => 'id', 'message' => 'Модель не существует'],
            [['category_id'], 'required', 'message' => 'Выберите класс'],
            [['category_id'], 'exist', 'targetClass' => Category::className(), 'targetAttribute' => 'id', 'message' => 'Класс не существует'],
            [['acriss'], 'safe'],
            [['deposit', 'discount'], 'double', 'message' => 'Введите корректное значение'],
            [['discount_type'], 'in', 'range' => [static::DISCOUNT_TYPE_FIXED, static::DISCOUNT_TYPE_PERCENT], 'message' => 'Неверное значение типи скидки'],
            [['attr_capacity', 'attr_fuel', 'attr_seat', 'attr_rear_drive', 'attr_engine', 'attr_body', 'attr_conditioner', 'attr_transmission'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'show_in_homepage' => 'Показывать на главной',
            'thumbnail' => 'Миниатюра',
            'sticker_id' => 'Стикер',
            'brand_id' => 'Марка',
            'model_id' => 'Модель',
            'category_id' => 'Класс',
            'acriss' => 'Международная классификация (ACRISS)',
            'deposit' => 'Залог',
            'discount' => 'Скидка',
            'discount_type' => 'Тип скидки',
            'attr_capacity' => 'Объем двигателя',
            'attr_fuel' => 'Расход топлива л/100 км',
            'attr_seat' => 'Количество мест',
            'attr_rear_drive' => 'Привод',
            'attr_engine' => 'Тип двигателя',
            'attr_body' => 'Кузов',
            'attr_conditioner' => 'C кондиционером',
            'attr_transmission' => 'Трансмиссия',
        ];
    }

    public function afterFind()
    {
        if (is_null($this->_title)) {
            $this->_title = implode(' ', array_filter([$this->brand->getTitle(), $this->model->getTitle()]));
            $this->_edit_link = Url::to(['/admin/park/car/edit', 'id' => $this->id]);

            foreach ($this->translations as $language => $translation) {
                if ($translation->title) {
                    $this->_title .= ' ' . $translation->title;
                    $this->_edit_link = Url::to(['/admin/park/car/edit', 'id' => $this->id, 'language' => $language]);
                    break;
                }
            }
        }

        //$this->attributeValues = $this->getAttributeValues()->all();

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

    public function getTranslations()
    {
        return $this->hasMany(CarTranslation::className(), ['car_id' => 'id'])
            ->indexBy('language');
    }

    public function getTranslation()
    {
        return $this->hasOne(CarTranslation::className(), ['car_id' => 'id'])
            ->where([
                CarTranslation::tableName() . '.status' => CarTranslation::STATUS_PUBLISHED,
                CarTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public function getImages()
    {
        return $this->hasMany(CarImage::className(), ['car_id' => 'id']);
    }

    public function getSticker()
    {
        return $this->hasOne(Sticker::className(), ['id' => 'sticker_id'])
            ->joinWith('translation');
    }

    public function getTranslatedSticker()
    {
        return $this->getSticker()
            ->joinWith('translation');
    }

    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id'])
            ->joinWith('translation');
    }

    public function getTranslatedBrand()
    {
        return $this->getBrand()
            ->joinWith('translation');
    }

    public function getModel()
    {
        return $this->hasOne(Model::className(), ['id' => 'model_id']);
    }

    public function getTranslatedModel()
    {
        return $this->getModel()
            ->joinWith('translation');
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getTranslatedCategory()
    {
        return $this->getCategory()
            ->joinWith('translation');
    }

    public function getAttributeValues()
    {
        return $this->hasMany(AttributeValue::className(), ['id' => 'attribute_value_id'])
            ->viaTable('car_attribute_value', ['car_id' => 'id'])
            ->indexBy('id');
    }

    public function getTranslatedAttributeValues()
    {
        return $this->getAttributeValues()
            ->joinWith('translation')
            ->joinWith('translatedMainAttribute');
    }

    public static function getMinimumPrice($car_id)
    {
        $minimum_car_price = CarPrices::find()
            ->select('
                LEAST(
                    ' . CarPrices::tableName() . '.`price_1`,
                    ' . CarPrices::tableName() . '.`price_3`,
                    ' . CarPrices::tableName() . '.`price_6`,
                    ' . CarPrices::tableName() . '.`price_8`,
                    ' . CarPrices::tableName() . '.`price_15`,
                    ' . CarPrices::tableName() . '.`price_29`
                )  AS `minimum`
            ')
            ->where([
                CarPrices::tableName() . '.car_id' => $car_id,
                CarPrices::tableName() . '.object' => 'city',
            ])
            ->andWhere([
                'or',
                ['<>', CarPrices::tableName() . '.price_1', 0],
                ['<>', CarPrices::tableName() . '.price_3', 0],
                ['<>', CarPrices::tableName() . '.price_6', 0],
                ['<>', CarPrices::tableName() . '.price_8', 0],
                ['<>', CarPrices::tableName() . '.price_15', 0],
                ['<>', CarPrices::tableName() . '.price_29', 0],
            ])
            ->orderBy(['minimum' => SORT_ASC])
            ->limit(1)
            ->asArray()
            ->one();

        return $minimum_car_price ? $minimum_car_price['minimum'] : 0;
    }

    public function getInsurance50()
    {
        $result = $this->hasOne(CarPrices::className(), ['car_id' => 'id'])
            ->where([
                'object' => 'insurance_50',
            ])
            ->one();

        if (!$result) {
            $result = new CarPrices;
            $result->loadDefaultValues();
            $result->car_id = $this->id;
            $result->object = 'insurance_50';
        }

        $result->title = 'Суперстраховка 50';

        return $result;
    }

    public function getAdditionalPrices()
    {
        return $this->hasMany(CarPrices::className(), ['car_id' => 'id'])
            ->andOnCondition(['object' => ['insurance_50', 'insurance_100', 'assistance']])
            ->andOnCondition([
                'and',
                ['<>', CarPrices::tableName() . '.price_1', 0],
                ['<>', CarPrices::tableName() . '.price_3', 0],
                ['<>', CarPrices::tableName() . '.price_6', 0],
                ['<>', CarPrices::tableName() . '.price_8', 0],
                ['<>', CarPrices::tableName() . '.price_15', 0],
                ['<>', CarPrices::tableName() . '.price_29', 0],
            ])
            ->indexBy('object');
    }

    public function getInsurance100()
    {
        $result = $this->hasOne(CarPrices::className(), ['car_id' => 'id'])
            ->where([
                'object' => 'insurance_100',
            ])
            ->one();

        if (!$result) {
            $result = new CarPrices;
            $result->loadDefaultValues();
            $result->car_id = $this->id;
            $result->object = 'insurance_100';
        }

        $result->title = 'Суперстраховка 100';

        return $result;
    }

    public function getAssistance()
    {
        $result = $this->hasOne(CarPrices::className(), ['car_id' => 'id'])
            ->where([
                'object' => 'assistance',
            ])
            ->one();

        if (!$result) {
            $result = new CarPrices;
            $result->loadDefaultValues();
            $result->car_id = $this->id;
            $result->object = 'assistance';
        }

        $result->title = 'Ассистанс';

        return $result;
    }

    public function getCities()
    {
        /**
         * @var City $city
         * @var City|array $cities
         */
        $results = $this->hasMany(CarPrices::className(), ['car_id' => 'id'])
            ->where([
                'object' => 'city',
            ])
            ->indexBy('object_id')
            ->all();

        $cities = City::find()
            ->joinWith('translations')
            ->groupBy(City::tableName() . '.id')
            ->orderBy([City::tableName() . '.created_at' => SORT_ASC])
            ->indexBy('id')
            ->all();

        $old_cities_index = array_diff(array_keys($results), array_keys($cities));
        $new_cities_index = array_diff(array_keys($cities), array_keys($results));

        foreach ($old_cities_index as $old_city_index) {
            $results[$old_city_index]->delete();
        }

        if ($new_cities_index) {
            foreach ($new_cities_index as $new_city_index) {
                $city_result = new CarPrices;
                $city_result->loadDefaultValues();
                $city_result->title = $cities[$new_city_index]->getTitle();
                $city_result->car_id = $this->id;
                $city_result->object = 'city';
                $city_result->object_id = $cities[$new_city_index]->id;

                $results[] = $city_result;
            }
        }

        foreach ($results as $result) {
            $result->title = $cities[$result->object_id]->getTitle();
        }

        return $results;
    }

    public function getCity($id)
    {
        $result = $this->hasOne(CarPrices::className(), ['car_id' => 'id'])
            ->where([
                'object' => 'city',
                'object_id' => $id,
            ])
            ->one();

        if (!$result) {
            $result = new CarPrices;
            $result->loadDefaultValues();
            $result->car_id = $this->id;
            $result->object = 'city';
            $result->object_id = $id;
        }

        return $result;
    }

    public function getCityPrice()
    {
        return $this->hasOne(CarPrices::className(), ['car_id' => 'id'])
            ->from(['car_prices_table' => CarPrices::tableName()])
            ->andOnCondition(['car_prices_table.object' => 'city']);
    }

    public function getTranslatedCities()
    {
        return $this->hasMany(City::className(), ['id' => 'object_id'])
            ->viaTable(CarPrices::tableName(), ['car_id' => 'id'])
            ->joinWith('translation')
            ->indexBy('id');
    }

    public function getTranslatedCityPrice()
    {
        return $this->hasOne(CarPrices::className(), ['car_id' => 'id'])
            ->from(['car_prices_table' => CarPrices::tableName()])
            ->andWhere([
                CarPrices::tableName() . '.object' => 'city',
            ])
            ->andWhere([
                'and',
                ['<>', CarPrices::tableName() . '.price_1', 0],
                ['<>', CarPrices::tableName() . '.price_3', 0],
                ['<>', CarPrices::tableName() . '.price_6', 0],
                ['<>', CarPrices::tableName() . '.price_8', 0],
                ['<>', CarPrices::tableName() . '.price_15', 0],
                ['<>', CarPrices::tableName() . '.price_29', 0],
            ]);
    }
}
