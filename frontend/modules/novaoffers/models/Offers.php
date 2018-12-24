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

/**
 * This is the model class for table "easyii_offers".
 *
 * @property integer $offer_id
 * @property integer $content_id
 * @property integer $type_id
 * @property integer $to_main_old
 * @property integer $how_days
 * @property string $price
 * @property integer $price_prefix
 * @property string $title_old
 * @property string $image_old
 * @property string $short_old
 * @property string $text_old
 * @property string $slug_old
 * @property string $pre_image_old
 * @property string $pre_text_old
 * @property string $pre_options_old
 * @property string $coordinates
 * @property string $pos
 * @property integer $time_old
 * @property integer $views_old
 * @property integer $status_old
 */

class Offers extends \common\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public $region_name;
    public $region_id;
    public $country_id;
    public $property_list;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'easyii_offers';
    }
    /**
     * @inheritdoc
     */
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
            [['price', 'how_days'], 'required'],
            [['price'], 'number', 'max' => 100000000],
            ['how_days', 'integer', 'max' => 366],
            ['coordinates', 'string', 'max' => 64],
            ['price_prefix','boolean'],
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