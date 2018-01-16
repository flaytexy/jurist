<?php

namespace app\modules\currency\models;

use app\modules\park\models\Car;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\Cookie;

/**
 * Class Currency
 * @package app\modules\currency\models
 *
 * @property int $id
 * @property string $thumbnail
 * @property int $system
 *
 * @property CurrencyTranslation|array $translations
 */
class Currency extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public $language = 'ru-RU';

    private $_title = null;
    private $_edit_link = null;

    public static $_default = null;
    public static $_current = null;

    public static function getAll()
    {
        return Currency::find()
            ->select([
                Currency::tableName() . '.iso',
                Currency::tableName() . '.default',
                Currency::tableName() . '.exchange',
                CurrencyTranslation::tableName() . '.title',
                CurrencyTranslation::tableName() . '.before',
                CurrencyTranslation::tableName() . '.after',
                CurrencyTranslation::tableName() . '.decimals',
                CurrencyTranslation::tableName() . '.dec_point',
                CurrencyTranslation::tableName() . '.thousands_sep',
            ])
            ->joinWith('translations', false)
            ->where([
                Currency::tableName() . '.status' => Currency::STATUS_PUBLISHED,
                CurrencyTranslation::tableName() . '.language' => Yii::$app->language,
            ])
            ->asArray()
            ->all();
    }

    public static function getDefault()
    {
        if (is_null(static::$_default)) {
            static::$_default = Currency::find()
                ->select([
                    Currency::tableName() . '.iso',
                    Currency::tableName() . '.default',
                    Currency::tableName() . '.exchange',
                    CurrencyTranslation::tableName() . '.title',
                    CurrencyTranslation::tableName() . '.before',
                    CurrencyTranslation::tableName() . '.after',
                    CurrencyTranslation::tableName() . '.decimals',
                    CurrencyTranslation::tableName() . '.dec_point',
                    CurrencyTranslation::tableName() . '.thousands_sep',
                ])
                ->joinWith('translations', false)
                ->where([
                    Currency::tableName() . '.default' => 1,
                    Currency::tableName() . '.status' => Currency::STATUS_PUBLISHED,
                    CurrencyTranslation::tableName() . '.language' => Yii::$app->language,
                ])
                ->asArray()
                ->one();
        }

        return static::$_default;
    }

    public static function getCurrent()
    {
        if (is_null(static::$_current)) {

            static::$_current = Currency::find()
                ->select([
                    Currency::tableName() . '.iso',
                    Currency::tableName() . '.default',
                    Currency::tableName() . '.exchange',
                    CurrencyTranslation::tableName() . '.title',
                    CurrencyTranslation::tableName() . '.before',
                    CurrencyTranslation::tableName() . '.after',
                    CurrencyTranslation::tableName() . '.decimals',
                    CurrencyTranslation::tableName() . '.dec_point',
                    CurrencyTranslation::tableName() . '.thousands_sep',
                ])
                ->joinWith('translations', false)
                ->where([
                    Currency::tableName() . '.iso' => Yii::$app->request->cookies->get('currency'),
                    Currency::tableName() . '.status' => Currency::STATUS_PUBLISHED,
                    CurrencyTranslation::tableName() . '.language' => Yii::$app->language,
                ])
                ->asArray()
                ->one();

            if (!static::$_current) {
                static::$_current = static::getDefault();
            }
        }

        return static::$_current;
    }

    public static function setCurrent($currency)
    {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'currency',
            'value' => $currency,
            'expire' => time() + 31536000,
        ]));
    }

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
                    $this->_edit_link = Url::to(['/admin/currency/default/edit', 'id' => $this->id, 'language' => $language]);
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
            [['default', 'status'], 'boolean'],

            [['iso'], 'required', 'message' => 'Введите код валюты'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'default' => 'По-умолчанию',
            'iso' => 'Код валюты (ISO 4217)',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(CurrencyTranslation::className(), ['currency_id' => 'id'])->indexBy('language');
    }

    public static function format($value, $wrap = true, $exchange = true)
    {
        $currency = static::getCurrent();

        if ($exchange && !$currency['default']) {
            $default = static::getDefault();

            $value = ceil($value * ($default['exchange'] / $currency['exchange']));
        }

        if (!$wrap) {
            $currency['before'] = $currency['after'] = '';
        }

        return $currency['before'] . (is_int((int)$value) ? number_format($value, $currency['decimals'], $currency['dec_point'], $currency['thousands_sep']) : 'N/A') . $currency['after'];
    }

    public static function formatDiscount($discount_type, $discount)
    {
        switch ($discount_type) {
            case Car::DISCOUNT_TYPE_FIXED:
                return static::format($discount);
                break;
            case Car::DISCOUNT_TYPE_PERCENT:
                return static::format($discount, false, false) . '%';
                break;
            default:
                return static::format($discount, false);
                break;
        }
    }

    public static function dayPrice($period, $prices)
    {
        $day_price = 0;

        $period = (int)$period;

        if ($period < 3) {
            $day_price = $prices['price_1'];
        } elseif ($period < 6) {
            $day_price = $prices['price_3'];
        } elseif ($period < 8) {
            $day_price = $prices['price_6'] / 7;
        } elseif ($period < 15) {
            $day_price = $prices['price_8'];
        } elseif ($period < 29) {
            $day_price = $prices['price_15'];
        } else {
            $day_price = $prices['price_29'];
        }

        return static::format($day_price);
    }

    public static function periodPrice($period, $prices, $discount_type = null, $discount = 0, $formatted = true)
    {
        $period = (int)$period;

        if ($period < 3) {
            $period_price = $prices['price_1'] * $period;
        } elseif ($period < 6) {
            $period_price = $prices['price_3'] * $period;
        } elseif ($period < 8) {
            $period_price = $prices['price_6'];
        } elseif ($period < 15) {
            $period_price = $prices['price_8'] * $period;
        } elseif ($period < 29) {
            $period_price = $prices['price_15'] * $period;
        } else {
            $period_price = $prices['price_29'] * $period;
        }

        switch ($discount_type) {
            case Car::DISCOUNT_TYPE_FIXED:
                $period_price -= $discount;
                break;
            case Car::DISCOUNT_TYPE_PERCENT:
                $period_price = ($discount / 100) * $period_price;
                break;
        }

        return $formatted ? static::format($period_price) : $period_price ;
    }
}
