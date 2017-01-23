<?php
namespace frontend\modules\seo\models;

use Yii;
use common\behaviors\MySluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;
use frontend\behaviors\Optionable;
use frontend\models\Photo;
use yii\helpers\StringHelper;

class Seo extends \frontend\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

//    var $robots;
//    var $sitemap;
//    var $scripts_footer;

    public static function tableName()
    {
        return 'easyii_seo_full';
    }

    public function rules()
    {
        return [
            [['robots', 'scripts_footer'], 'required'],
            [['robots', 'scripts_footer'], 'string', 'min' => 6],
            [['sitemap'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xml'],
/*            [['text', 'title'], 'required'],
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
            ['tagNames', 'safe']*/
        ];
    }

    public function attributeLabels()
    {
        return [
           'title' => Yii::t('easyii', 'Title'),
        ];
    }

    public function behaviors()
    {
        return [];
    }

/*    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $settings = Yii::$app->getModule('admin')->activeModules['seo']->settings;
            return true;
        } else {
            return false;
        }
    }*/

    public function afterDelete()
    {
        parent::afterDelete();

        //if($this->image){
            //@unlink(Yii::getAlias('@webroot').$this->image);
        //}
    }
}