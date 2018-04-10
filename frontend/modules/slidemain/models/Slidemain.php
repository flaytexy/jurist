<?php
namespace frontend\modules\slidemain\models;

use common\behaviors\CountriesBehavior;
use common\models\country\CountryAssign;
use common\models\country\CountryData;
use frontend\behaviors\CountryAble;
use common\models\country\Country;
use frontend\models\Option;
use frontend\models\OptionAssign;
use Yii;
use common\behaviors\MySluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;
use frontend\behaviors\Optionable;
use frontend\models\Photo;
use yii\helpers\StringHelper;

/**
 * @property string $countryNames
 *
 * @property $countries
 * @property $properties
 * @property $country
 * @property $slide_main_id
 */
class Slidemain extends \frontend\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public $region_name;
    public $region_id;
    public $country_id;
    public $property_list;

    public static function tableName()
    {
        return 'easyii_slidemain';
    }

    public function rules()
    {
        return [
            //[['title', 'title_en', 'text', 'text_en', 'short', 'short_en'], 'required'],
            [['title', 'title_en'], 'string', 'max' => 128],
            [['url', 'short', 'short_en', 'pre_text', 'pre_text_en'], 'string', 'max' => 512],
            [['title', 'title_en', 'text', 'text_en', 'short', 'short_en', 'url'], 'trim'],
            ['image', 'image', 'extensions' => 'png, jpg, gif'],
        ];

//        return [
//            [['text', 'title', 'location_zone_id', 'how_days'], 'required'],
//            [['pre_options', 'title', 'website', 'location_title'], 'string', 'max' => 128],
//            [['url'], 'string', 'max' => 512],
//            [['title', 'short', 'text'], 'trim'],
//            [['pos', 'coordinates'], 'string', 'max' => 64],
//            ['to_main', 'integer', 'max' => 1],
//            ['personal', 'integer', 'max' => 1],
//            [['price'], 'required'],
//            [['price', 'min_deposit'], 'number', 'max' => 100000000],
//            ['how_days', 'integer', 'max' => 999],
//            ['image', 'image', 'extensions' => 'png, jpg, gif'],
//            ['image_flag', 'image', 'extensions' => 'png, jpg, gif',
//                'minWidth' => 100, 'maxWidth' => 1200,
//                'minHeight' => 100, 'maxHeight' => 1200,
//            ],
//            ['location_zone_id', 'integer', 'max' => 99],
//
//            [['views', 'time', 'status', 'type_id'], 'integer'],
//            ['time', 'default', 'value' => time()],
//            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
//            ['slug', 'default', 'value' => null],
//            ['status', 'default', 'value' => self::STATUS_ON],
//            ['optionNames', 'safe'],
//            ['tagNames', 'safe'],
//            ['countryNames', 'safe']
//        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'type_id' => Yii::t('easyii', 'Тип'),
            'text' => Yii::t('easyii', 'Text'),
            'short' => Yii::t('easyii/slidemain', 'Short'),
            'to_main' => Yii::t('easyii/slidemain', 'На главную'),
            'price' => Yii::t('easyii/slidemain', 'Цена'),
            'how_days' => Yii::t('easyii/slidemain', 'Дней'),
            'image' => Yii::t('easyii', 'Image'),
            'time' => Yii::t('easyii', 'Date'),
            'slug' => Yii::t('easyii', 'Slug'),
            'optionNames' => Yii::t('easyii', 'Options'),
            'tagNames' => Yii::t('easyii', 'Tags'),
            'location_title' => Yii::t('easyii/slidemain', 'Страна'),
            'Personal' => Yii::t('easyii/slidemain', 'Пприсутствие'),
            'pre_text' => Yii::t('easyii', 'Alt текст для картинки'),
            'pre_text_en' => Yii::t('easyii', 'Alt текст для картинки (EN)'),
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
            'countryable' => CountryAble::className(),
            //'CountriesBehavior' => CountriesBehavior::className(),

        ];
    }

    /**
     * @return $this
     */
/*    public function getCountries()
    {
        return $this->hasMany(CountryData::className(), ['country_id' => 'country_id'])
            ->viaTable('{{%country_assign}}', ['item_id' => "{$this->primaryKey}"]);
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

            $settings = Yii::$app->getModule('admin')->activeModules['slidemain']->settings;
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

//    public function geProperties()
//    {
//        return $this->hasMany('ModelA', array('id' => 'aid1'))->viaTable('tbl_b', array('aid2' => 'id'));
//    }
//    public function relations()
//    {
//        return array(
//            'issues'=>array(self::HAS_ONE, 'Issue', 'issue_id'),
//        );
//    }

    public function getProperties()
    {
        return $this->hasMany(Option::className(), ['option_id' => 'option_id'])
            ->viaTable(OptionAssign::tableName(), ['item_id' => 'slide_main_id'], function ($query) {
                /* @var $query \yii\db\ActiveQuery */
                $query->andWhere([OptionAssign::tableName() .'.class' => Slidemain::className()]);
            });
    }

    /*
        public function getTranslation()
        {
            return $this->hasOne(self::getModelClassName(), ['content_id' => 'id'])
                //->andOnCondition([ContentTranslation::tableName() . '.language' => Yii::$app->language])
                ->where([
                    ContentTranslation::tableName() . '.status' => Content::STATUS_PUBLISHED,
                    ContentTranslation::tableName() . '.language' => Yii::$app->language
                ]);
        }


         public function getItems()
        {
            return $this->hasMany(Item::className(), ['id' => 'item_id'])
                ->viaTable('order_item', ['order_id' => 'id']);
        }

        public function getCountry() {
            return $this->hasOne(CountryAssign::className(), ['id' => 'country_id']);
        }*/
}