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
            [['text', 'title'], 'required'],
            ['pre_options', 'string', 'max' => 128],
            [['title', 'short', 'text'], 'trim'],
            ['title', 'string', 'max' => 128],
            ['pos', 'string', 'max' => 64],
            ['to_main', 'integer', 'max' => 1],
            [['price'], 'required'],
            [['price'], 'number', 'max' => 100000000],
            ['how_days', 'integer', 'max' => 999],
            ['coordinates', 'string', 'max' => 64],
            ['image', 'image'],
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
            'tagNames' => Yii::t('easyii', 'Tags')
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

        foreach($this->getPhotos()->all() as $photo){
            $photo->delete();
        }
    }
}