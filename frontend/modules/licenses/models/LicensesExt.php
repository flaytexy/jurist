<?php

namespace frontend\modules\licenses\models;

use Yii;


//use frontend\behaviors\CountryAble;
//
//use common\behaviors\MySluggableBehavior;
//use frontend\behaviors\SeoBehavior;
//use frontend\behaviors\Taggable;
////use frontend\behaviors\Optionable;
//use frontend\models\Photo;
//use yii\helpers\StringHelper;


/**
 * This is the model class for table "licenses".
 *
 * @property integer $licenses_id
 * @property integer $content_id
 * @property integer $type_id
 * @property integer $lic_type
 */
class LicensesExt extends \common\components\ActiveRecord
{

    const STATUS_OFF = 0;
    const STATUS_ON = 1;

//    public $region_name;
//    public $region_id;
//    public $country_id;
//    public $property_list;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'licenses';
    }

    //    public function behaviors()
//    {
//        return [
//            //'seoBehavior' => SeoBehavior::className(),
////            'taggabble' => Taggable::className(),
//            //'optionabble' => Optionable::className(),
////            'sluggable' => [
////                'class' => MySluggableBehavior::className(),
////                'attribute' => 'title',
////                'ensureUnique' => true
////            ],
//            'countryable' => CountryAble::className(),
//            //'CountriesBehavior' => CountriesBehavior::className(),
//
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_id', 'type_id', 'lic_type'], 'required'],
            [['content_id'], 'integer'],
            [['type_id', 'lic_type'], 'integer'], // !!!! NOT string

            //['pre_options', 'string', 'max' => 128],
            //['title', 'string', 'max' => 128],
//            ['pos', 'string', 'max' => 64],
//            [
//                ['price', 'how_days'], 'required'],
//            [['price'], 'number', 'max' => 100000000],
//            ['how_days', 'integer', 'max' => 366],
//            ['coordinates', 'string', 'max' => 64],
            //['optionNames', 'safe'],
            //['tagNames', 'safe'],

//            ['countryNames', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'licenses_id' => Yii::t('app', 'Licenses ID'),
            'content_id' => Yii::t('app', 'Content ID'),
            'type_id' => Yii::t('app', 'Type ID'),
            'lic_type' => Yii::t('app', 'Lic Type'),
        ];
    }
}
