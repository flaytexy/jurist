<?php
namespace frontend\modules\banks\models;

use common\behaviors\CountriesBehavior;
use common\models\country\CountryAssign;
use common\models\country\CountryData;
use frontend\behaviors\CountryAble;
use common\models\country\Country;
use Yii;
use common\behaviors\MySluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;
use frontend\behaviors\Optionable;
use frontend\models\Photo;
use yii\helpers\StringHelper;

/**
 * @property string $countryNames
 */
class Banks extends \frontend\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public $property_list;

    public static function tableName()
    {
        return 'easyii_banks';
    }

    public function rules()
    {
        return [
            [['text', 'title', 'location_zone_id', 'how_days'], 'required'],
            [['pre_options', 'title', 'website', 'location_title'], 'string', 'max' => 128],
            [['title', 'short', 'text'], 'trim'],
            [['pos', 'coordinates'], 'string', 'max' => 64],
            ['to_main', 'integer', 'max' => 1],
            ['personal', 'integer', 'max' => 1],
            [['price'], 'required'],
            [['price', 'min_deposit'], 'number', 'max' => 100000000],
            ['how_days', 'integer', 'max' => 999],
            ['image', 'image', 'extensions' => 'png, jpg, gif'],
            ['image_flag', 'image', 'extensions' => 'png, jpg, gif',
                'minWidth' => 100, 'maxWidth' => 1200,
                'minHeight' => 100, 'maxHeight' => 1200,
            ],
            ['location_zone_id', 'integer', 'max' => 99],

            [['views', 'time', 'status', 'type_id'], 'integer'],
            ['time', 'default', 'value' => time()],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['status', 'default', 'value' => self::STATUS_ON],
            ['optionNames', 'safe'],
            ['tagNames', 'safe'],
            ['countryNames', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'type_id' => Yii::t('easyii', 'Тип'),
            'text' => Yii::t('easyii', 'Text'),
            'short' => Yii::t('easyii/banks', 'Short'),
            'to_main' => Yii::t('easyii/banks', 'На главную'),
            'price' => Yii::t('easyii/banks', 'Цена'),
            'how_days' => Yii::t('easyii/banks', 'Дней'),
            'image' => Yii::t('easyii', 'Image'),
            'time' => Yii::t('easyii', 'Date'),
            'slug' => Yii::t('easyii', 'Slug'),
            'optionNames' => Yii::t('easyii', 'Options'),
            'tagNames' => Yii::t('easyii', 'Tags'),
            'location_title' => Yii::t('easyii/banks', 'Страна'),
            'Personal' => Yii::t('easyii/banks', 'Пприсутствие'),
        ];
    }

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
            'taggabble' => Taggable::className(),
            'optionabble' => Optionable::className(),
            'sluggable' => [
                'class' => MySluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true
            ],
            //'countryable' => CountryAble::className(),
            'CountriesBehavior' => CountriesBehavior::className(),
/*            [
                'class' => CountriesBehavior::className(),
            ],*/
        ];
    }

/*    public function getCountries()
    {
        return $this->hasMany(CountryData::className(), ['country_id' => 'country_id'])
            ->viaTable('{{%country_assign}}', ['item_id' => 'bank_id']);
    }*/

/*    public function getCountries()
    {
        return $this->hasMany(Country::className(), ['id' => 'country_id'])
            ->viaTable('{{%country_assign}}', ['item_id' => 'bank_id']);
    }*/
/*    public function getCountries()
    {
        return $this->hasMany(Country::className(), ['country_id' => 'country_id'])
            ->viaTable('{{%country_assign}}', ['item_id' => 'bank_id']);
    }*/

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->price))
                $this->price = str_replace(",", ".", $this->price);
            else {
                $this->price = '0.00';
            }
            if (!empty($this->min_deposit)){
                $this->min_deposit = str_replace(",", ".", $this->min_deposit);
            }
            else{
                $this->min_deposit = '0.00';
            }

            $settings = Yii::$app->getModule('admin')->activeModules['banks']->settings;
            $this->short = StringHelper::truncate($settings['enableShort'] ? $this->short : strip_tags($this->text), $settings['shortMaxLength']);

            if (!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']) {
                @unlink(Yii::getAlias('@webroot') . $this->oldAttributes['image']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if ($this->image) {
            @unlink(Yii::getAlias('@webroot') . $this->image);
        }

        if ($this->image_flag) {
            @unlink(Yii::getAlias('@webroot') . $this->image_flag);
        }
    }


/*
    public function getCountry() {
        return $this->hasOne(CountryAssign::className(), ['id' => 'country_id']);
    }*/
}