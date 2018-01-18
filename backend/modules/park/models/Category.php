<?php

namespace backend\modules\park\models;

use Yii;
use backend\modules\attachment\models\Attachment;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Category
 * @package backend\modules\park\models
 *
 * @property int $id
 * @property int $thumbnail
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CategoryTranslation|array $translations
 */
class Category extends ActiveRecord
{
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

    public function afterFind()
    {
        if (is_null($this->_title)) {
            foreach ($this->translations as $language => $translation) {
                if ($translation->title) {
                    $this->_title = $translation->title;
                    $this->_edit_link = Url::to(['/admin/park/category/edit', 'id' => $this->id, 'language' => $language]);
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
            [['language', 'thumbnail'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'thumbnail' => 'Миниатюра',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(CategoryTranslation::className(), ['category_id' => 'id'])
            ->indexBy('language');
    }

    public function getTranslation()
    {
        return $this->hasOne(CategoryTranslation::className(), ['category_id' => 'id'])
            ->andWhere([
                CategoryTranslation::tableName() . '.status' => CategoryTranslation::STATUS_PUBLISHED,
                CategoryTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public function getThumbnail()
    {
        return $this->hasOne(Attachment::className(), ['id' => 'thumbnail']);
    }

    public function getCar()
    {
        return $this->hasMany(Car::className(), ['category_id' => 'id']);
    }

    public function getTranslatedCars()
    {
        return $this->hasMany(Car::className(), ['category_id' => 'id'])
            ->from(['car_table' => Car::tableName()])
            ->joinWith('translation');
    }

    public static function getDropdownList()
    {
        /**
         * @var Category $model
         */
        $result = [];

        $models = static::find()
            ->with('translations')
            ->all();

        foreach ($models as $model) {
            $result[$model->id] = $model->getTitle();
        }

        return $result;
    }

    /*public static function getMinimumPrice($category_id)
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
            ->innerJoin(Car::tableName(), CarPrices::tableName() . '.`car_id` = ' . Car::tableName() . '.`id`')
            ->innerJoin(Category::tableName(), Car::tableName() . '.`category_id` = ' . Category::tableName() . '.`id`')
            ->andWhere([
                CarPrices::tableName() . '.object' => 'city',
                CarPrices::tableName() . '.object_id' => City::getDefaultCity()['id'],
                Category::tableName() . '.id' => $category_id,
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
    }*/

    public function getMinimumPrice()
    {
        return $this->hasOne(CarPrices::className(), ['car_id' => 'id'])
            ->viaTable(Car::tableName(), ['category_id' => 'id'])
            ->andOnCondition([CarPrices::tableName() . '.object' => 'city'])

            ->select([
                CarPrices::tableName() . '.car_id',
                '
                    LEAST(
                        ' . CarPrices::tableName() . '.`price_1`,
                        ' . CarPrices::tableName() . '.`price_3`,
                        ' . CarPrices::tableName() . '.`price_6`,
                        ' . CarPrices::tableName() . '.`price_8`,
                        ' . CarPrices::tableName() . '.`price_15`,
                        ' . CarPrices::tableName() . '.`price_29`
                    )  AS `minimum`
                ',
            ])
            ->orderBy([
                CarPrices::tableName() . '.`price_29`' => SORT_ASC,
            ]);
    }
}
