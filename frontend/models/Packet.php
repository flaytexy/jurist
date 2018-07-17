<?php
namespace frontend\models;

use Yii;
use common\components\ActiveRecord;
use common\behaviors\MySluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;


class Packet extends \common\components\ActiveRecord
{
    public $options;

    /*    public static function tableVia()
        {
            return 'easyii_offers_packets_options';
        }*/

    public static function tableName()
    {
        return 'easyii_packets';
    }

    public function rules()
    {
        return [
            //[['title'], 'required'],
            [['title'], 'trim'],
            ['title', 'string', 'max' => 128],
            ['tagNames', 'safe']
        ];
    }
    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
            'taggabble' => Taggable::className(),
            'sluggable' => [
                'class' => MySluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true
            ],
        ];
    }

    /*    public function getPacketsOptions () {
            return $this->hasMany(OffersPacketsOptions::className(), ['option_id' => 'option_id'])
                ->viaTable(OffersPackets::tableVia(), ['packet_id' => 'packet_id']);
        }*/
}