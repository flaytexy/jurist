<?php
namespace frontend\modules\offers\models;


use frontend\components\ActiveRecord;
use Yii;
use common\behaviors\MySluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;


class OffersPackets extends ActiveRecord
{

    public $itemId;

    public static function tableName()
    {
        return 'easyii_offers_packets';
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

}