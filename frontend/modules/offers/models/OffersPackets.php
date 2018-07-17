<?php
namespace frontend\modules\offers\models;


use common\components\ActiveRecord;
use Yii;
use common\behaviors\MySluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;


class OffersPackets extends ActiveRecord
{

    public $itemId;
    public $options;

/*    public static function tableVia()
    {
        return 'easyii_offers_packets_options';
    }*/

    public static function tableName()
    {
        return 'easyii_packets';
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