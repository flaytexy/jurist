<?php
namespace frontend\modules\offers\models;

use common\models\country\CountryData;
use frontend\behaviors\CountryAble;
use Yii;
use common\behaviors\MySluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;
use frontend\behaviors\Optionable;
use frontend\models\Photo;
use yii\helpers\StringHelper;

class Offers extends \common\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public $region_name;
    public $region_id;
    public $country_id;
    public $property_list;

    public static function tableName()
    {
        return 'easyii_offers';
    }

    public function rules()
    {
        return [
            [['text', 'title'], 'required'],
            ['pre_options', 'string', 'max' => 128],
            [['title', 'short', 'text'], 'trim'],
            ['title', 'string', 'max' => 128],
            ['pos', 'string', 'max' => 64],
            ['to_main', 'integer', 'max' => 1],
            [['price'], 'required'],
            [['price'], 'number', 'max' => 100000000],
            ['how_days', 'integer', 'max' => 255],
            ['coordinates', 'string', 'max' => 64],
            //['pre_image', 'image'],
            //['pre_image', 'string', 'max' => 128],
            ['image', 'image'],
            [['views', 'time', 'status', 'type_id'], 'integer'],
            ['time', 'default', 'value' => time()],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['status', 'default', 'value' => self::STATUS_ON],
            ['optionNames', 'safe'],
            ['tagNames', 'safe'],
            ['countryNames', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'type_id' => Yii::t('easyii', 'Регион'),
            'text' => Yii::t('easyii', 'Text'),
            'short' => Yii::t('easyii/offers', 'Short'),
            'to_main' => Yii::t('easyii/offers', 'На главную'),
            'price' => Yii::t('easyii/offers', 'Цена'),
            'how_days' => Yii::t('easyii/offers', 'Дней'),
            'image' => Yii::t('easyii', 'Image'),
            'time' => Yii::t('easyii', 'Date'),
            'slug' => Yii::t('easyii', 'Slug'),
            'optionNames' => Yii::t('easyii', 'Options'),
            'tagNames' => Yii::t('easyii', 'Tags'),
            'countryNames' => Yii::t('easyii', 'Страна')
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
            ->viaTable('{{%country_assign}}', ['item_id' => "{$this->primaryKey()[0]}"]);
    }*/

    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['item_id' => 'offer_id'])->where(['class' => self::className()])->sort();
    }



    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            $this->price = str_replace(",", ".", $this->price);

            $settings = Yii::$app->getModule('admin')->activeModules['offers']->settings;
            $this->short = StringHelper::truncate($settings['enableShort'] ? $this->short : strip_tags($this->text), $settings['shortMaxLength']);

            if(!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['image']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if($this->image){
            @unlink(Yii::getAlias('@webroot').$this->image);
        }

        foreach($this->getPhotos()->all() as $photo){
            $photo->delete();
        }
    }
}