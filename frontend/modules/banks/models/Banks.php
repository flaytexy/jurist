<?php
namespace frontend\modules\banks\models;

use Yii;
use common\behaviors\MySluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;
use frontend\behaviors\Optionable;
use frontend\models\Photo;
use yii\helpers\StringHelper;

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
            [['text', 'title', 'location_zone_id'], 'required'],
            [['pre_options','title','website','location_title'], 'string', 'max' => 128],
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
            ['location_zone_id', 'integer', 'max' => 1],

            [['views', 'time', 'status', 'type_id'], 'integer'],
            ['time', 'default', 'value' => time()],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['status', 'default', 'value' => self::STATUS_ON],
            ['optionNames', 'safe'],
            ['tagNames', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'type_id' => Yii::t('easyii', 'Регион'),
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
        ];
    }

    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['item_id' => 'bank_id'])->where(['class' => self::className()])->sort();
    }



    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->price = str_replace(",", ".", $this->price);
            $this->min_deposit = str_replace(",", ".", $this->min_deposit);

            $settings = Yii::$app->getModule('admin')->activeModules['banks']->settings;
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

        if($this->image_flag){
            @unlink(Yii::getAlias('@webroot').$this->image_flag);
        }

        foreach($this->getPhotos()->all() as $photo){
            $photo->delete();
        }
    }
}