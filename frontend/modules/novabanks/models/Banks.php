<?php
namespace frontend\modules\novabanks\models;

use frontend\models\Option;
use frontend\models\OptionAssign;
use Yii;

/**
 * @property string $location_title
 * @property string $how_days
 * @property string $website
 * @property string $pos
 * @property string $coordinates
 * @property string $price
 * @property string $min_deposit
 * @property string $personal
 * @property string $time
 * @property string $location_zone_id
 */
class Banks extends \common\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public static function tableName()
    {
        return 'easyii_banks';
    }

    public function rules()
    {
        return [
            [['location_zone_id', 'how_days'], 'required'],
            [['pre_options', 'website', 'location_title'], 'string', 'max' => 128],
            [['website', 'location_title'], 'trim'],
            [['pos', 'coordinates'], 'string', 'max' => 64],

            ['personal', 'integer', 'max' => 1],
            [['price'], 'required'],
            [['price', 'min_deposit'], 'number', 'max' => 100000000],
            ['how_days', 'integer', 'max' => 999],
            ['location_zone_id', 'integer', 'max' => 99],
            ['time', 'default', 'value' => time()],

            //['to_main', 'integer', 'max' => 1],
            //[['image', 'pre_image'], 'image', 'extensions' => 'png, jpg, gif'],
            //['image', 'image', 'extensions' => 'jpg, jpeg'], // 'png, jpg, jpeg, gif'
            //['pre_image', 'image', 'extensions' => 'jpg, jpeg'], //'png, jpg, jpeg, gif'

            ['image_flag', 'extensions' => 'png, jpg, jpeg, gif',
                'minWidth' => 100, 'maxWidth' => 1240,
                'minHeight' => 100, 'maxHeight' => 1240,
            ],
           // [['views', 'time', 'status', 'type_id', 'rating', 'rating_to_main'], 'integer'],

            //['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            //['slug', 'default', 'value' => null],
           // ['status', 'default', 'value' => self::STATUS_ON],

            //[['rating'], 'default', 'value'=> 1005],

            //['optionNames', 'safe'],
            //['tagNames', 'safe'],
            //['countryNames', 'safe']
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

            return true;
        } else {
            return false;
        }
    }


//    public function getProperties()
//    {
//        return $this->hasMany(Option::className(), ['option_id' => 'option_id'])
//            ->viaTable(OptionAssign::tableName(), ['item_id' => 'bank_id'], function ($query) {
//                /* @var $query \yii\db\ActiveQuery */
//                $query->andWhere([OptionAssign::tableName() .'.class' => Banks::className()]);
//        });
//    }
}