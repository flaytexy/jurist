<?php

namespace backend\modules\park\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class City
 * @package backend\modules\park\models
 *
 * @property int $id
 * @property string $phones
 * @property int $show_in_header
 * @property int $show_in_footer
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CityTranslation|array $translations
 */
class City extends ActiveRecord
{
    public $language = 'ru-RU';

    private $_title = null;
    private $_edit_link = null;

    public $_phones = [];

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    public function afterFind()
    {
        if (is_null($this->_title)) {
            foreach ($this->translations as $language => $translation) {
                if ($translation->title) {
                    $this->_title = $translation->title;
                    $this->_edit_link = Url::to(['/admin/park/city/edit', 'id' => $this->id, 'language' => $language]);
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
            [['phones', 'language'], 'safe'],
            [['show_in_header', 'show_in_footer'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phones' => 'Телефон',
            'show_in_header' => 'Отображать в верхней части',
            'show_in_footer' => 'Отображать в нижней части',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(CityTranslation::className(), ['city_id' => 'id'])
            ->indexBy('language');
    }

    public function getTranslation()
    {
        return $this->hasOne(CityTranslation::className(), ['city_id' => 'id'])
            ->andWhere([
                CityTranslation::tableName() . '.status' => CityTranslation::STATUS_PUBLISHED,
                CityTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public function getPrices()
    {
        return $this->hasMany(CarPrices::className(), ['object_id' => 'id']);
    }

    public function getTranslatedCarPrices()
    {
        return $this->getPrices()
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

    public function getPrice()
    {
        return $this->hasOne(CarPrices::className(), ['object_id' => 'id'])
            ->from(['car_prices_table' => CarPrices::tableName()]);
    }

    public function getCarPrice()
    {
        return $this->hasOne(CarPrices::className(), ['object_id' => 'id'])
            ->from(['car_prices_table' => CarPrices::tableName()])
            ->andOnCondition(['car_prices_table.car_id' => Car::tableName(). '.id']);
    }

    public function getTranslatedCarPrice()
    {
        return $this->getPrices()
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

    public static function getHeaderCities()
    {
        $models = City::find()
            ->select([
                City::tableName() . '.phones',
                CityTranslation::tableName() . '.title',
            ])
            ->innerJoinWith('translations', false)
            ->where([
                City::tableName() . '.show_in_header' => 1,
                CityTranslation::tableName() . '.status' => CityTranslation::STATUS_PUBLISHED,
                CityTranslation::tableName() . '.language' => Yii::$app->language,
            ])
            ->andWhere(['<>', City::tableName() . '.phones', serialize([])])
            ->orderBy([CityTranslation::tableName() . '.title' => SORT_ASC])
            ->asArray()
            ->all();

        return $models;
    }

    public static function getFooterCities()
    {
        $models = City::find()
            ->select([
                City::tableName() . '.phones',
                CityTranslation::tableName() . '.title',
            ])
            ->innerJoinWith('translations', false)
            ->andWhere([
                City::tableName() . '.show_in_footer' => 1,
                CityTranslation::tableName() . '.status' => CityTranslation::STATUS_PUBLISHED,
                CityTranslation::tableName() . '.language' => Yii::$app->language,
            ])
            ->andWhere(['<>', City::tableName() . '.phones', serialize([])])
            ->orderBy([CityTranslation::tableName() . '.title' => SORT_ASC])
            ->asArray()
            ->all();

        return $models;
    }

    public static function getDefaultCity()
    {
        $model = null;

        if ($city_id = Yii::$app->request->get('city')) {
            $model = City::find()
                ->joinWith('translation')
                ->andWhere([
                    City::tableName() . '.id' => $city_id,
                ])
                ->asArray()
                ->one();
        }

        if (!$model) {
            $model = City::find()
                ->joinWith('translation')
                ->andWhere([
                    City::tableName() . '.default' => 1,
                ])
                ->asArray()
                ->one();
        }

        return $model;
    }

    public static function getCities()
    {
        return City::find()
            ->joinWith('translation')
            ->orderBy([CityTranslation::tableName() . '.title' => SORT_ASC])
            ->asArray()
            ->all();
    }

    public static function getParkCities()
    {
        return City::find()
            ->joinWith('translation')
//            ->joinWith('translatedCarPrices', false)
            ->orderBy([CityTranslation::tableName() . '.title' => SORT_ASC])
            ->asArray()
            ->indexBy('id')
            ->all();
    }
}
