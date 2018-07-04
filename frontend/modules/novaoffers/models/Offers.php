<?php
namespace frontend\modules\novaoffers\models;

use Yii;
use frontend\behaviors\CountryAble;

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

    public function behaviors()
    {
        return [
            //'seoBehavior' => SeoBehavior::className(),
            //'taggabble' => Taggable::className(),
            //'optionabble' => Optionable::className(),
//            'sluggable' => [
//                'class' => MySluggableBehavior::className(),
//                'attribute' => 'title',
//                'ensureUnique' => true
//            ],
            'countryable' => CountryAble::className(),
            //'CountriesBehavior' => CountriesBehavior::className(),

        ];
    }

    public function rules()
    {
        return [
            //['pre_options', 'string', 'max' => 128],
            //['title', 'string', 'max' => 128],
            ['pos', 'string', 'max' => 64],
            [['price'], 'required'],
            [['price'], 'number', 'max' => 100000000],
            ['how_days', 'integer', 'max' => 255],
            ['coordinates', 'string', 'max' => 64],
            //['optionNames', 'safe'],
            //['tagNames', 'safe'],
            ['countryNames', 'safe']
        ];
    }

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            $this->price = str_replace(",", ".", $this->price);

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
    }
}